<?php

namespace App\Jobs;

use App\Mail\PriceChangeNotification;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPriceChangeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     * @param float $oldPrice
     * @param float $newPrice
     * @param string $email
     */
    public function __construct(
        protected Product $product,
        protected float $oldPrice,
        protected float $newPrice,
        protected string $email
    )
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new PriceChangeNotification(
                $this->product,
                $this->oldPrice,
                $this->newPrice
            ));

    }
}
