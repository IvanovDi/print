<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseModuleController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;


abstract class ForgotPasswordController extends BaseModuleController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    protected $guestMiddleware = 'guest';

    protected $broker = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware);
    }

    public function broker()
    {
        return Password::broker($this->broker);
    }

    public function showLinkRequestForm()
    {
        return $this->view('auth.passwords.email');
    }
}