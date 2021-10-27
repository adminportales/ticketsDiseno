<?php

namespace App\Listeners;

use App\Events\OrderStatusChangeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatusChangeEvent  $event
     * @return void
     */
    public function handle(OrderStatusChangeEvent $event)
    {
        //
    }
}
