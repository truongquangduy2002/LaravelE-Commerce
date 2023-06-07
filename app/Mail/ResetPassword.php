<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $resetUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.reset_password')
            ->subject('Đặt lại mật khẩu')
            ->with([
                'resetUrl' => $this->resetUrl,
            ]);
    }
}
