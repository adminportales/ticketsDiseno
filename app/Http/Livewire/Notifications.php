<?php

namespace App\Http\Livewire;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Notifications extends Component
{
    public $countNotifications, $unreadNotifications;

    public $active = false;

    public function getListeners()
    {
        return [
            // Public Channel
            'echo:delivery,TicketDeliverySendEvent' => 'updateNotifies',
            'echo:notification,MessageSendEvent' => 'updateNotifies',
            'echo:status,ChangeStatusSendEvent' => 'updateNotifies',
            'echo:creado,TicketCreateSendEvent' => 'updateNotifies',
            'echo:priority,ChangePrioritySendEvent' => 'updateNotifies',
            'echo:change,ChangeTicketSendEvent' => 'updateNotifies',
            'echo:arts,TicketDeliveryArtsSendEvent' => 'updateNotifies',
            'echo:info,TicketUpdateSendEvent' => 'updateNotifies',
        ];
    }
    public function render()
    {
        $this->active = true;
        $this->countNotifications = count(auth()->user()->unreadNotifications);
        $this->unreadNotifications = auth()->user()->unreadNotifications;
        return view('layouts.components.livewire.notifications');
    }
    public function markAsRead(DatabaseNotification $notification)
    {
        // $this->active = false;
        // $notification->markAsRead();
        // $this->reset(['countNotifications', 'unreadNotifications', 'active']);
    }

    public function updateNotifies()
    {
        \Log::info('Evento TicketDeliveryArtsSendEvent recibido');
        $this->reset(['countNotifications', 'unreadNotifications', 'active']);
    }
}
