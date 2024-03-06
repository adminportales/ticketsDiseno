<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageTicket extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $emisor;
    public $receptor;
    public $title_ticket;
    public $message;
    public function __construct($emisor, $receptor,$title_ticket,$message)
    {
        $this->emisor = $emisor;
        $this->receptor = $receptor;
        $this->title_ticket = $title_ticket;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->markdown('mail.Information.MessageTicket',[
                        'emisor'=>$this->emisor,
                        'receptor'=>$this->receptor,
                        'title_ticket'=>$this->title_ticket,
                        'message' =>$this->message,
                    ])
                    ->subject('Tienes un mensaje del sistema de tickets')
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
            //
        ];
    }
}
