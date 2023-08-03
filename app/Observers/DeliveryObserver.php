<?php

namespace App\Observers;

use App\Models\Delivery;
use App\Http\TelegramNotifier;

class DeliveryObserver
{
    protected $telegramNotifier;

    public function __construct(TelegramNotifier $telegramNotifier)
    {
        $this->telegramNotifier = $telegramNotifier;
    }

    /**
     * Handle the Delivery "created" event.
     */
    public function created(Delivery $delivery): void
    {
        $this->telegramNotifier->created($delivery);
    }

    /**
     * Handle the Delivery "updated" event.
     */
    public function updated(Delivery $delivery): void
    {
        $this->telegramNotifier->updated($delivery);
    }

    /**
     * Handle the Delivery "deleted" event.
     */
    public function deleted(Delivery $delivery): void
    {
        $this->telegramNotifier->deleted($delivery);
    }

    /**
     * Handle the Delivery "restored" event.
     */
    public function restored(Delivery $delivery): void
    {
        // ...
    }

    /**
     * Handle the Delivery "force deleted" event.
     */
    public function forceDeleted(Delivery $delivery): void
    {
        // ...
    }
}
