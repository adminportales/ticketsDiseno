<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingInformation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $ticket;
    public $emisor;
    public $receptor;
    public $idTicket;
    public $message;
    public function __construct($ticket, $emisor,$receptor, $idTicket, $message)
    {
        $this->ticket  = $ticket;
        $this->emisor  = $emisor;
        $this->receptor = $receptor;
        $this->idTicket  = $idTicket;
        $this->message = $message;
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

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->markdown('mail.Information.MissingInformation',[
                        'url' => url('/designer/ticketShow' . '/' . $this->idTicket),
                        'ticket'=>$this->ticket,
                        'emisor'=>$this->emisor,
                        'receptor'=>$this->receptor,
                        'message' =>$this->message,
                    ])
                    ->subject('TICKET CON FALTANTE DE INFORMACIÓN')
                    ->from('adminportales@promolife.com.mx', 'T-Design');
    }
}
