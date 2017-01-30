<?php

namespace Modules\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Modules\Backend\Http\Controllers\BaseBackendTrait;

class AdminResetPasswordController extends ResetPasswordController
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
    use BaseBackendTrait;

    protected $broker = 'admin';

    protected $guestMiddleware = 'guest:admin';

    protected $redirectTo = '/admin';

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