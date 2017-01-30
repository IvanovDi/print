<?php

namespace Modules\Frontend\Notifications;

class UserAcceptInvitation extends BaseUserNotification
{
    protected $invitation;
    protected $accept;

    public function __construct($invitation, $accept = true)
    {
        $this->invitation = $invitation;
        $this->accept = $accept;
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
        return ['database'];
    }

    public function toArray()
    {
        return array_merge($this->invitation->toArray(), ['accept' => $this->accept]);
    }

}