<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $ticket;
    public $receptor;
    public $emisor;
    public $idTicket;
    public function __construct($ticket, $receptor, $emisor, $idTicket)
    {
        $this->ticket  = $ticket;
        $this->receptor = $receptor;
        $this->emisor = $emisor;
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
        return ['mail'];
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
            ->markdown('mail.Information.TicketUpdate', [
                'url' => url('/designer/ticketShow' . '/' . $this->idTicket), 'ticket' => $this->ticket,
                'ticket' => $this->ticket,
                'receptor' => $this->receptor,
                'emisor' => $this->emisor,
            ])
            ->subject('TICKET ACTUALIZADO')
            ->from('adminportales@promolife.com.mx', 'T-Design');
    }
}
