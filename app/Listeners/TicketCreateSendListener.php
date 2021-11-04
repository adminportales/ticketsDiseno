<?php

namespace App\Listeners;

use App\Events\TicketCreateSendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TicketCreateSendListener
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
     * @param  TicketCreateSendEvent  $event
     * @return void
     */
    public function handle(TicketCreateSendEvent $event)
    {
        //
    }
}
