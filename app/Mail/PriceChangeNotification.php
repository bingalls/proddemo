<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceChangeNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Product $product,
        private readonly float $oldPrice,
        private readonly float $newPrice
    )
    {}

    /**
     * Get the message envelope.
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Product Price Change Notification',
        );
    }

    /**
     * Get the message content definition.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.price-change',
            with: [
                'product' => $this->product,
                'oldPrice' => $this->oldPrice,
                'newPrice' => $this->newPrice,
            ]
        );
    }
}
