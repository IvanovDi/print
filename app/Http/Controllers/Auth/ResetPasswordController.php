<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseModuleController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

abstract class ResetPasswordController extends BaseModuleController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    protected $broker = null;

    protected $guestMiddleware = 'guest';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware);
    }

    public function showResetForm(Request $request, $token)
    {
        return $this->view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function guard()
    {
        return \Auth::guard($this->getGuard());
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return \Password::broker($this->broker);
    }

}