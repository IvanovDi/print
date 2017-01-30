<?php

namespace Modules\Backend\Entities;

use App\Entities\BaseUser;
use App\Notifications\ResetPasswordNotification;

class AdminUser extends BaseUser
{
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'backend'));
    }
}