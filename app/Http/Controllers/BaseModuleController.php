<?php

namespace App\Http\Controllers;

use App\Components\RedirectIfNull;
use App\Http\Controllers\Controller;

abstract class BaseModuleController extends Controller
{
    use RedirectIfNull;

    protected $currentUser;

    protected $guard;

    protected function getCurrentUser()
    {
        if ($this->currentUser === null) {
            $this->currentUser = \Auth::guard($this->getGuard())->user();
        }

        return $this->currentUser;
    }

    protected function getCurrentUserId()
    {
        return $this->getCurrentUser()->id;
    }

    abstract protected function getModuleName();
    abstract protected function getGuard();

    /**
     * @param $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view, array $data = [])
    {
        return view($this->getModuleName(). '::' . $view, $data);
    }
}
