<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;
    public $subdomain;

    public function __construct($name, $email, $password, $subdomain)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->subdomain = $subdomain;
    }

    public function build()
    {
        return $this->subject('Welcome! Your Account Details')
            ->view('emails.user_registration')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'subdomain' => $this->subdomain,
            ]);
    }
}