<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirm_Order_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.confirm_order')->from('khaphan1411@gmail.com', 'RADIUS Hoa Khô')
            ->subject('[XÁC NHẬN ĐƠN HÀNG] Xác Nhận Đăng Ký Tại RADIUS Hoa Khô')
            ->with($this->data);
    }
}
