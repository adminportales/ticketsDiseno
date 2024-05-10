<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketDeliveryArts extends Notification
{
    use Queueable;
    public $ticket;
    public $emisor;
    public $status;
    public $idTicket;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($idTicket, $ticket, $emisor, $status)
    {
        $this->ticket  = $ticket;
        $this->emisor  = $emisor;
        $this->status  = $status;
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('mail.arts.deliveryarts', [
                'url' => url('/tickets' . '/' . $this->idTicket),
                'ticket' => $this->ticket,
                'emisor' => $this->emisor,
                'status' => $this->status,
                'idTicket' => $this->idTicket,
            ])
            ->subject('Modificaciones en un ticket')
            ->from('adminportales@promolife.com.mx', 'T-Design');
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
            'status' => $this->status,
            'idTicket' => $this->idTicket,
        ];
    }
}
