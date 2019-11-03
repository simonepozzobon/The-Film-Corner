<?php

namespace App\Notifications;

use App\Teacher;
use App\Student;
use App\SharedSession;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChatNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session, $sender, $receiver)
    {
        $this->type = 'chat';
        $this->session = $session;
        $this->app_category = $session->app->category->section;
        $this->sender = $sender;
        $this->receiver = $receiver;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'session' => $this->session,
            'user' => $notifiable,
            'sharedTime' => date('Y-m-d H:m:i')
        ];
    }


}
