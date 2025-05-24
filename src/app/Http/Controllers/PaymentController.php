<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handleCallback(Request $request)
    {
        $payload = json_decode($request->getContent());

        if ($payload->transaction_status === 'settlement') {
            $user = User::where('email', $payload->customer_details->email)->first();
            $batchId = $payload->order_id; // You may want to store batch id in metadata instead

            if ($user) {
                // Assign role
                $user->assignRole('student');

                // Enroll to batch
                $user->batches()->attach($batchId);
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
