<?php

namespace App\Listeners;

use App\Events\ChangeTicketSendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeTicketSendListener
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
     * @param  ChangeTicketSendEvent  $event
     * @return void
     */
    public function handle(ChangeTicketSendEvent $event)
    {
        //
    }
}
