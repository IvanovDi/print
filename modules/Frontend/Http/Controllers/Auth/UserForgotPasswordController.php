<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Frontend\Http\Controllers\BaseFrontendTrait;

class UserForgotPasswordController extends ForgotPasswordController
{
    use BaseFrontendTrait;

    protected $guestMiddleware = 'guest:user';

    protected $broker = 'user';

    public function __construct()
    {
        parent::__construct();
    }
}