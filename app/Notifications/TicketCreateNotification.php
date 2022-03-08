<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $ticket;
    public $emisor;
    public $idTicket;
    public function __construct($idTicket, $ticket, $emisor)
    {
        $this->ticket  = $ticket;
        $this->emisor  = $emisor;
        $this->idTicket  = $idTicket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->ticket,
            'emisor' => $this->emisor,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('mail.create.create', [
                'url' => url('/designer/ticketShow' . '/' . $this->idTicket),
                'ticket' => $this->ticket,
                'emisor' => $this->emisor,
                'idTicket' => $this->idTicket,
            ])
            ->subject('Se ha creado un ticket')
            ->from('admin@tdesign.promolife.lat', 'T-Design');
    }
}
