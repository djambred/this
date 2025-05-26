<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Services\CreateSnapTokenService;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $product = Product::findOrFail($request->product_id);
        $orderId = 'BOOTCAMP-' . strtoupper(Str::random(10));

        $transaction = [
            'order_id' => $orderId,
            'gross_amount' => $product->price,
            'first_name' => $request->name,
            'email' => $request->email,
        ];

        $midtrans = new CreateSnapTokenService($transaction);
        $snapToken = $midtrans->getSnapToken();

        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ]);
    }

    public function storeResult(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'student_id' => 'required|string',
            'student_origin' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'github_name' => 'nullable|string',
            'github_url' => 'nullable|url',
            'product_id' => 'required|exists:products,id',
            'midtrans_result' => 'required|array',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email already registered.'], 409);
        }

        $plainPassword = Str::random(8);
        $hashedPassword = Hash::make($plainPassword);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        $user->assignRole('student');

        Student::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'student_origin' => $request->student_origin,
            'phone' => $request->phone,
            'address' => $request->address,
            'github_name' => $request->github_name,
            'github_url' => $request->github_url,
            'product_id' => $request->product_id,
        ]);

        $orderId = $request->midtrans_result['order_id'] ?? 'UNKNOWN';
        $transactionStatus = $request->midtrans_result['transaction_status'] ?? 'pending';

        $status = match ($transactionStatus) {
            'settlement', 'capture' => 'success',
            'pending' => 'pending',
            default => 'failed',
        };

        Payment::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'order_id' => $orderId,
            'status' => $status,
        ]);

        Mail::to($user->email)->send(new \App\Mail\SendLoginDetailsMail($user, $plainPassword));

        return response()->json(['message' => 'User registered successfully.']);
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? 'pending';

        $status = match ($transactionStatus) {
            'settlement', 'capture' => 'success',
            'pending' => 'pending',
            default => 'failed',
        };

        Payment::where('order_id', $orderId)->update(['status' => $status]);

        return response()->json(['message' => 'Payment status updated']);
    }
}
