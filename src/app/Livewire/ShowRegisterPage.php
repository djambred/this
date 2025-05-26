<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Student;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ShowRegisterPage extends Component
{
    protected $listeners = ['midtrans:payment-success' => 'handlePaymentSuccess'];

    public int $productId;

    public string $name = '';
    public string $student_id = '';
    public string $student_origin = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $github_name = '';
    public string $github_url = '';

    public int $paymentAmount = 0;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->paymentAmount = Product::findOrFail($productId)->price ?? 100000;
    }

    public function payAndRegister()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:100',
            'student_origin' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'github_name' => 'required|string',
            'github_url' => 'required|url',
        ]);

        $product = Product::findOrFail($this->productId);
        $paymentAmount = $product->price ?? 100000;
        $orderId = 'BOOTCAMP-' . Str::upper(Str::random(10));

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $paymentAmount,
            ],
            'customer_details' => [
                'first_name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ],
        ];

        $response = Http::withBasicAuth(config('midtrans.server_key'), '')
            ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

        if ($response->successful()) {
            $snapToken = $response->json('token') ?? $response->json('snap_token');

            if (!$snapToken) {
                $this->addError('payment', 'Snap token not received from Midtrans.');
                return;
            }

            session()->put('registration_data', $this->only([
                'name', 'student_id', 'student_origin', 'email',
                'phone', 'address', 'github_name', 'github_url',
            ]));

            $this->emit('midtrans:show-snap', ['snapToken' => $snapToken]);
        } else {
            $this->addError('payment', 'Failed to generate payment token.');
        }
    }

    public function handlePaymentSuccess($result)
    {
        $data = session()->pull('registration_data');
        $product = Product::findOrFail($this->productId);

        Student::create(array_merge($data, [
            'batch_id' => $product->batch_id,
            'payment_status' => 'paid',
            'payment_result' => json_encode($result),
        ]));

        session()->flash('success', 'Payment successful! You have been registered.');
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.show-register-page', [
            'product' => Product::with(['batch.course', 'batch.schedules'])->findOrFail($this->productId),
            'paymentAmount' => $this->paymentAmount,
        ]);
    }
}
