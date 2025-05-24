<?php

namespace App\Livewire;

use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowRegisterPage extends Component
{
    public $batchId;
    public $batch;

    // Form inputs
    public $name;
    public $email;
    public $phone;

    public $paymentAmount;

    public function mount($batchId)
    {
        $this->batchId = $batchId;
        $this->batch = Batch::with('course')->findOrFail($batchId);

        // Set price or get from batch or course
        $this->paymentAmount = 100;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
    ];

    public function payAndRegister()
    {
        //$this->validate();

        // try {
        //     $pending = PendingRegistration::create([
        //         'batch_id' => $this->batchId,
        //         'name' => $this->name,
        //         'email' => $this->email,
        //         'phone' => $this->phone,
        //         'status' => 'pending',
        //         'amount' => $this->paymentAmount,
        //         'payment_method' => 'midtrans',
        //     ]);

        //     // Simulate payment process here (replace with real payment integration)
        //     // If payment success:
        //     $pending->update([
        //         'status' => 'confirmed',
        //         'payment_transaction_id' => 'TXN' . time(),
        //     ]);

        //     $registration = Registration::create([
        //         'batch_id' => $this->batchId,
        //         'name' => $this->name,
        //         'email' => $this->email,
        //         'phone' => $this->phone,
        //         'registered_at' => now(),
        //         'status' => 'active',
        //     ]);

            $this->reset(['name', 'email', 'phone']);

            session()->flash('success', 'Registration and payment successful!');

        // } catch (Exception $e) {
        //     $this->addError('payment', 'Payment failed: ' . $e->getMessage());
        // }
    }

    public function render()
    {
        return view('livewire.show-register-page');
    }
}
