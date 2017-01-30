<?php

namespace Modules\Frontend\Notifications;

use Modules\Frontend\Entities\Invitation;

class InvitationForCompanyNotification extends BaseUserNotification
{
    protected $invitation;
    protected $resend = false;

    public function __construct($invitation)
    {
        if ($invitation instanceof Invitation) {
            $this->invitation = $invitation;
        } else {
            $this->invitation = Invitation::find($invitation);
            $this->resend = true;
        }
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
        return array_merge($this->invitation->toArray(), ['resend' => $this->resend]);
    }

}