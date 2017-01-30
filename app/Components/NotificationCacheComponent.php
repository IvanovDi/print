<?php

namespace App\Components;

use Modules\Frontend\Http\Controllers\BaseFrontendTrait;

class NotificationCacheComponent extends BaseCacheComponent
{
    use BaseFrontendTrait;

    public function getDataForCache()
    {
        return \Auth::guard($this->getGuard())->user()->unReadNotifications;
    }

    protected function getCacheName($id = null)
    {
        if ($id === null) {
            $id = \Auth::guard($this->getGuard())->user()->id;
        }
        return $this->getGuard() . $id;
    }
}