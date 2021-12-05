<?php

namespace App\Notifications;

use App\Model\VisaProcess\VisaCancelChat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\s\Messages\MailMessage;

class VisaChat extends Notification
{
    use Queueable;

    /**
     * Create a new  instance.
     *
     * @return void
     */
    public function __construct(VisaCancelChat $chatData)
    {
        //
        $this->chatData=$chatData;
    }



    /**
     * Get the 's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }



    /**
     * Get the mail representation of the .
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\s\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the .')
//                    ->action(' Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    public function toDatabase($notifiable)
    {
        return [
            'chatData' => $this->id,
            'user' => $notifiable,
            'message' => "New Message Received"
        ];
    }

    /**
     * Get the array representation of the .
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
