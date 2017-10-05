<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShareSession extends Notification
{
    use Queueable;

    protected $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
        $this->student = $session->student->name;
        $this->app_name = $session->app->title;
        $this->app_category = $session->app->category->name;
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
            'student' => $this->student,
            'app_category' => $this->app_category,
            'app_name' => $this->app_name,
            'session' => $this->session,
            'user' => $notifiable,
            'sharedTime' => date('Y-m-d H:m:i')
        ];
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
