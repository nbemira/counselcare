<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($actionUrl)
    {
        $this->actionUrl = $actionUrl;
        $this->color = 'primary'; // or set to 'success' or 'error' based on your requirement
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset-password')->with([
            'actionUrl' => $this->actionUrl,
            'actionText' => 'Reset Password',
            'color' => $this->color,
            'level' => 'primary', // or set to 'success' or 'error' based on your requirement
            'introLines' => ['You are receiving this email because we received a password reset request for your account.'],
            'outroLines' => ['If you did not request a password reset, no further action is required.'],
        ]);
    }
}
