<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Coupon;

class VoucherEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $coupon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Coupon $coupon)
    {
        $this->user = $user;
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.coupon')
            ->subject('Thông báo Coupon')
            ->with([
                'user' => $this->user,
                'coupon' => $this->coupon,
            ]);
    }
}
