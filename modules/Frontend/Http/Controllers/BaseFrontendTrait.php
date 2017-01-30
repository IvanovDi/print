<?php

namespace Modules\Frontend\Http\Controllers;

trait BaseFrontendTrait
{
    protected function getModuleName()
    {
        return 'frontend';
    }

    protected function getGuard()
    {
        return 'user';
    }
}