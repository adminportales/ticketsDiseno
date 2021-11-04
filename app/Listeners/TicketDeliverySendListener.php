<?php

namespace App\Listeners;

use App\Events\TicketDeliverySendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TicketDeliverySendListener
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
     * @param  TicketDeliverySendEvent  $event
     * @return void
     */
    public function handle(TicketDeliverySendEvent $event)
    {
        //
    }
}
