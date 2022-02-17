<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketDeliveryNotification extends Notification
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
            'idTicket' => $this->idTicket,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('mail.delivery.delivery', [
                'url' => url('/tickets' . '/' . $this->idTicket),  'ticket' => $this->ticket,
                'emisor' => $this->emisor,
                'idTicket' => $this->idTicket,
            ])
            ->subject('Tu solicitd ha sido resuelta')
            ->from('admin@tdesign.promolife.lat', 'T-Design');
    }
}
