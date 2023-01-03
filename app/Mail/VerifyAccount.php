<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.verify_account')->from('khaphan1411@gmail.com', 'RADIUS Hoa Khô')
            ->subject('[XÁC THỰC TÀI KHOẢN] Xác Nhận Đăng Ký Tài Khoản Tại RADIUS Hoa Khô')
            ->with($this->data);
    }
}
