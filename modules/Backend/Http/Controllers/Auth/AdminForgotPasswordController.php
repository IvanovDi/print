<?php

namespace Modules\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Backend\Http\Controllers\BaseBackendTrait;

class AdminForgotPasswordController extends ForgotPasswordController
{
    use BaseBackendTrait;

    protected $guestMiddleware = 'guest:admin';

    protected $broker = 'admin';

    public function __construct()
    {
        parent::__construct();
    }
}