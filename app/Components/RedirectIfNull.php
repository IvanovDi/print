<?php

namespace App\Components;

trait RedirectIfNull
{
    public function checkIfNull($object, $route = null, \Closure $action = null)
    {
        if ($action !== null) {
            $action();
        }
        if ($object === null) {
            throw new \App\Exceptions\RedirectToBackException($route);
        }
    }
}