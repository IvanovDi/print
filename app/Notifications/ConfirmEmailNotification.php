<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmEmailNotification extends Notification
{

    public $token;
    public $module;

    public function __construct($token, $module)
    {
        $this->token = $token;
        $this->module = $module;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Confirm Email.')
            ->action('Confirm Email', route($this->module . '.email_confirm', ['token' => $this->token]));
    }
}
