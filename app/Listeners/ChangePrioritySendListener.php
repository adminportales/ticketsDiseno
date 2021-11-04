<?php

namespace App\Listeners;

use App\Events\ChangePrioritySendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangePrioritySendListener
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
     * @param  ChangePrioritySendEvent  $event
     * @return void
     */
    public function handle(ChangePrioritySendEvent $event)
    {
        //
    }
}
