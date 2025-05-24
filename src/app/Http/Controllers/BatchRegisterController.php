<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Midtrans\Snap;
use Midtrans\Config;

class BatchRegisterController extends Controller
{
    public function show(Batch $batch)
    {
        return view('register.batch', compact('batch'));
    }

    public function checkout(Request $request, Batch $batch)
    {
        $user = auth()->user();

        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false; // Set true in production

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $batch->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'callbacks' => [
                'finish' => route('batch.register', $batch->id),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('register.payment', compact('snapToken', 'batch'));
    }
}
