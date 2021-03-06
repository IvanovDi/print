<?php

namespace Modules\Frontend\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Modules\Frontend\Entities\User;

class ActivatedDeactivatedUserNotification extends BaseUserNotification
{
    protected $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        $this->destroyCache($notifiable->id);
        return ['database', 'mail'];
    }


    public function toArray()
    {
        return $this->invitation->toArray();
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $company = User::find($this->invitation->company_id);
        return (new MailMessage())
            ->line('Company '. $company->company_real_name .' activated your account.');
    }

}