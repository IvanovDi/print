<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MessageFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Message';
    }
}
