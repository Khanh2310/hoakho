<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
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
        return $this->view('mail.reset_password')->from('khaphan1411@gmail.com', 'RADIUS Hoa Khô')
            ->subject('[LẤY LẠI MẬT KHẨU] Xác Nhận Lấy Lại Mật Khẩu Mới Tại RADIUS Hoa Khô')
            ->with($this->data);
    }
}
