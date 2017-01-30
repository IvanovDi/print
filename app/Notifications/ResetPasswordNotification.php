<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $module;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @param  string  $module
     * @return void
     */
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
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route($this->module . '.show_reset_form', $this->token))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
