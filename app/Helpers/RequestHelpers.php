<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class RequestHelpers
{
    public static function setActive($path, $active = 'active')
    {
        return Request::fullUrl() === $path ? $active : '';
    }
}