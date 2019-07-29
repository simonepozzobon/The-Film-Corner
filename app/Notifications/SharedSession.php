<?php

namespace App\Notifications;

use App\User;
use App\Session;

use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SharedSession extends Notification
{
    use Queueable;

    protected $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Session $session, User $sender)
    {
        // add app to session
        $formatted = $session;
        $formatted->app = $session->app;

        $this->session = $session;
        $this->sender = $sender;
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
            'session' => $this->session,
            'user' => $notifiable,
            'sharedTime' => date('Y-m-d H:m:i')
        ];
    }
}
