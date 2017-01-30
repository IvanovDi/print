<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationCacheComponentFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'NotificationCache';
    }
}
