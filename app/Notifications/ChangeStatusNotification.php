<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $ticket;
    public $emisor;
    public $status;
    public $idTicket;

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
        // return ['database', 'mail'];
        return ['database'];
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

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('mail.status.status', [
                'url' => url('/tickets' . '/' . $this->idTicket),
                'ticket' => $this->ticket,
                'emisor' => $this->emisor,
                'status' => $this->status,
                'idTicket' => $this->idTicket,
            ])
            ->subject('Modificaciones en un ticket')
            ->from('adminportales@promolife.com.mx', 'T-Design');
    }
}
