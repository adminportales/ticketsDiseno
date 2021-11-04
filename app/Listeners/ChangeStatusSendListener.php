<?php

namespace App\Listeners;

use App\Events\ChangeStatusSendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeStatusSendListener
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
     * @param  ChangeStatusSendEvent  $event
     * @return void
     */
    public function handle(ChangeStatusSendEvent $event)
    {
        //
    }
}
