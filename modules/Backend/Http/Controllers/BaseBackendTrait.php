<?php

namespace Modules\Backend\Http\Controllers;

trait BaseBackendTrait
{
    protected function getModuleName()
    {
        return 'backend';
    }

    protected function getGuard()
    {
        return 'admin';
    }
}