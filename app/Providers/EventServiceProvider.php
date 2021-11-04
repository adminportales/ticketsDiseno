<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\MessageSendEvent' => [
            'App\Listeners\MessageSendListener'
        ],
        'App\Events\ChangeTicketSendEvent' => [
            'App\Listeners\ChangeTicketSendListener'
        ],
        'App\Events\ChangePrioritySendEvent' => [
            'App\Listeners\ChangePrioritySendListener'
        ],
        'App\Events\TicketDeliverySendEvent' => [
            'App\Listeners\TicketDeliverySendListener'
        ],
        'App\Events\ChangeStatusSendEvent' => [
            'App\Listeners\ChangeStatusSendListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
