<?php

namespace Modules\Frontend\Http\Middleware;

class EmailConfirm
{
    public function handle($request, \Closure $next)
    {
        if (!\Auth::guard('user')->user()->email_confirm) {
            \Message::warning(['Confirm Email Notification. <a href="' . route('frontend.account.resendEmailConfirm') .'">Resend notification</a>']);
        }
        return $next($request);
    }
}