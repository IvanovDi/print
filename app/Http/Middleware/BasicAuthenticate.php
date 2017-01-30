<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class BasicAuthenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard)
    {
        $this->authenticate($guard);
        return $next($request);
    }

    protected function authenticate($guard)
    {
        if ($this->auth->guard($guard)->check()) {
            return $this->auth->shouldUse($guard);
        }

        throw new AuthenticationException($guard);
    }
}
