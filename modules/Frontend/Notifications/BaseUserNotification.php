<?php

namespace Modules\Frontend\Notifications;

use Illuminate\Notifications\Notification;

class BaseUserNotification extends Notification
{
    protected function destroyCache($id = null)
    {
        \NotificationCache::destroyCache($id);
    }
}