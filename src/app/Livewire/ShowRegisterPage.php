<?php

namespace App\Livewire;

use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowRegisterPage extends Component
{
    public Batch $batch;

    // Any other public properties, e.g. form inputs
    public $name;
    public $email;

    public function mount(Batch $batch)
    {
        $this->batch = $batch;
    }

    // This is the method you need
    public function register()
    {
        // Your registration logic here

        // For example, assign role 'student' to logged in user
        $user = Auth::user();

        if ($user) {
            $user->assignRole('student'); // Using Spatie role package or similar
            // Additional logic to attach batch to user, save registration, etc.
        }

        session()->flash('message', 'Successfully registered!');
    }

    public function render()
    {
        return view('livewire.show-register-page');
    }
}
