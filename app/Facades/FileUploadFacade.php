<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FileUploadFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'FileUpload';
    }
}
