<?php

namespace Modules\Frontend\Http\Middleware;

class IsCompany
{
    public function handle($request, \Closure $next)
    {
        if (\Auth::guard('user')->user()->is_company) {
            return $next($request);
        }

        return redirect()->route('frontend.main');
    }
}