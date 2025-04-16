<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order = $order->load('orderDetails.product'); // kèm sản phẩm
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('dduynam1@gmail.com', 'Shop Bánh'),
            subject: 'Xác nhận đơn hàng #' . $this->order->id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-success',
            with: ['order' => $this->order]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
