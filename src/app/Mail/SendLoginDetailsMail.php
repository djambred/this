<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;

class SendLoginDetailsMail extends Mailable
{
    public $user;
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Bootcamp Account Login Details')
            ->view('emails.login-details');
    }
}
