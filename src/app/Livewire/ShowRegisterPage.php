<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\User;
use App\Models\Student;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class ShowRegisterPage extends Component
{
    public $batchId;
    public $batch;

    // Form inputs
    public $student_id;
    public $student_origin;
    public $address;
    public $github_name;
    public $github_url;
    public $name;
    public $email;
    public $phone;


    public $paymentAmount;

    public function mount($batchId)
    {
        $this->batchId = $batchId;
        $this->batch = Batch::with('course')->findOrFail($batchId);

        // Set price or get from batch or course
        $this->paymentAmount = 100000;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'student_origin' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'github_name' => 'nullable|string|max:255',
        'github_url' => 'nullable|string|max:255',

    ];

    public function payWithMidtrans()
{
    $this->validate();

    // Midtrans config
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Generate Snap token
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . strtoupper(Str::random(10)),
            'gross_amount' => $this->paymentAmount,
        ],
        'customer_details' => [
            'first_name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    $this->dispatch('midtrans:show-snap', snapToken: $snapToken);
}


    public function payAndRegister()
    {
        $this->validate();

        try {
            $transactionId = 'MIDTRANS-' . strtoupper(Str::random(10));

            $plainPassword = Str::random(8);


            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($plainPassword),
            ]);


            $user->assignRole('student');


            Student::create([
                'user_id' => $user->id,
                'student_id' => $this->student_id ?? null,
                'student_origin' => $this->student_origin ?? 'kj',
                'phone' => $this->phone,
                'address' => $this->address,
                'github_name' => $this->github_name,
                'github_url' => $this->github_url,
            ]);


            Mail::to($user->email)->send(new UserRegisteredMail($user, $plainPassword));

            $this->reset([
                'name', 'email', 'phone',
                'student_id', 'student_origin', 'address',
                'github_name', 'github_url'
            ]);

            session()->flash('success', 'Registration and email sent successfully!');
        } catch (\Exception $e) {
            $this->addError('payment', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.show-register-page');
    }
}
