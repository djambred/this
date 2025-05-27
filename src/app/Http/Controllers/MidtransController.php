<?php

namespace App\Http\Controllers;

use App\Mail\SendLoginDetailsMail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Services\CreateSnapTokenService;
use App\Models\User;
use App\Models\Student;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }
    // Generate Midtrans Snap Token
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'captcha' => 'required|integer',
        ]);

        $expectedCaptcha = session('captcha_a') + session('captcha_b');

        if ((int) $request->captcha !== $expectedCaptcha) {
            return response()->json(['error' => 'CAPTCHA is incorrect.'], 422);
        }

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

    // Store the payment & user registration result after payment success
    public function storeResult(Request $request)
    {
        try {
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

            $loginUrl = url('/bootcamp');
            $whatsapp = new WhatsAppService();
            $whatsapp->sendMessage(
                $request->phone,
                    "Hi {$user->name}, welcome to Bootcamp!  ^=^n^s\n\n" .
                    "Login Details:\n" .
                    " ^=^s  Email: {$user->email}\n" .
                    " ^=^t^q Password: {$plainPassword}\n\n" .
                    " ^=^q^i Login here: {$loginUrl}"
                );

            // Send email with login details
            Mail::to($user->email)->send(new SendLoginDetailsMail($user, $plainPassword));


            return response()->json(['message' => 'Registration successful! Please check your email.']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Handle Midtrans webhook or notification
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
