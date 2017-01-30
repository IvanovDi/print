<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Modules\Frontend\Http\Controllers\BaseFrontendTrait;

class UserResetPasswordController extends ResetPasswordController
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
    use BaseFrontendTrait;

    protected $broker = 'user';

    protected $guestMiddleware = 'guest:user';

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}