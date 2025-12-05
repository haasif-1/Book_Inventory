<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // FIXED – declare property

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject("Your Order #{$this->order->id} is confirmed")
            ->view('emails.order_placed')
            ->with(['order' => $this->order]); // pass order to view
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_placed', // FIX THIS TOO (your previous view.name was wrong)
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
