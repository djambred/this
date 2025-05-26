<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class CreateSnapTokenService
{
    protected $order;

    public function __construct(array $order)
    {
        $this->order = $order;

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order['order_id'],
                'gross_amount' => $this->order['gross_amount'],
            ],
            'customer_details' => [
                'first_name' => $this->order['first_name'],
                'email' => $this->order['email'],
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
