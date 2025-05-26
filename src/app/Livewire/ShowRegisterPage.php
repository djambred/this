<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Services\CreateSnapTokenService;

class ShowRegisterPage extends Component
{
    public int $productId;
    public int $paymentAmount = 0;

    public string $name = '', $student_id = '', $student_origin = '', $email = '', $phone = '', $address = '', $github_name = '', $github_url = '';

    protected $listeners = ['midtrans:payment-success' => 'handlePaymentSuccess'];

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->paymentAmount = Product::findOrFail($productId)->price ?? 100000;
    }

    public function updatedGithubName($value)
    {
        $this->github_url = "https://github.com/" . trim($value);
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
        ]);

        $product = Product::findOrFail($this->productId);
        $orderId = 'BOOTCAMP-' . strtoupper(Str::random(10));

        // $transaction = [
        //         'order_id' => $orderId,
        //         'gross_amount' => $product->price,
        //         'first_name' => $this->name,
        //         'email' => $this->email,

        // ];
        // //dd($transaction);
        // if (!$product->snap_token) {
        //     # code...
        //     $midtrans = new CreateSnapTokenService($transaction);
        //     $snapToken = $midtrans->getSnapToken();
        //     $product->update(['snap_token'=>$snapToken]);
        //     //dd( $product);
        // } else {
        //     $snapToken = $product->snap_token;
        // }
        // //dd($snapToken);
        // return $snapToken;

        $order = [
            'order_id' => $orderId,
            'gross_amount' => $product->price ?? 100000,
            'first_name' => $this->name,
            'email' => $this->email,
        ];

        $snapToken = (new CreateSnapTokenService($order))->getSnapToken();
        //dd($snapToken);

        // Store form data temporarily for use after successful payment
        session()->put('registration_data', $this->only([
            'name', 'student_id', 'student_origin', 'email',
            'phone', 'address', 'github_name', 'github_url'
        ]));

        // Trigger JS event for Snap
        $this->dispatch ('midtrans:show-snap', ['snapToken' => $snapToken]);

        dd($snapToken);

    }

    public function handlePaymentSuccess($result)
    {
        $data = session()->pull('registration_data');
        $product = Product::findOrFail($this->productId);

        $student = Student::create([
            ...$data,
            'batch_id' => $product->batch_id,
            'payment_status' => 'paid',
            'payment_result' => json_encode($result),
        ]);

        $password = Str::random(8);

        $user = User::create([
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('student');

        Mail::to($user->email)->send(new \App\Mail\SendLoginDetailsMail($user, $password));

        session()->flash('success', 'Payment successful! Check your email for login details.');

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.show-register-page', [
            'product' => Product::with('batch.course')->findOrFail($this->productId),
        ]);
    }
}
