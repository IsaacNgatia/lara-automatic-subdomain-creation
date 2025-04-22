<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $accountName;
    public $password;
    public $subdomain;

    public function __construct($data)
    {
        $this->accountName = $data['accountName'];
        $this->password = $data['password'];
        $this->subdomain = $data['subdomain'];
    }

    public function build()
    {
        return $this->subject('Registration Successful')
            ->view('emails.user_registered')
            ->with([
                'accountName' => $this->accountName,
                'password' => $this->password,
                'subdomain' => $this->subdomain,
            ]);
    }
}