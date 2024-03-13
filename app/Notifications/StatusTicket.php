<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusTicket extends Notification
{
    use Queueable;

    public $ticket;
    public $status;
    public $emisor;
    public $idTicket;
    public function __construct($ticket,$status,$emisor,$idTicket)
    {
        $this->ticket = $ticket;
        $this->status = $status;
        $this->emisor  = $emisor;
        $this->idTicket  = $idTicket;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->ticket,
            'status' => $this->status,
            'emisor' => $this->emisor,
            'idTicket' => $this->idTicket,
        ];
    }
}
