<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Modules\Frontend\Http\Controllers\BaseFrontendTrait;

class UserLoginController extends LoginController
{
    use BaseFrontendTrait;

    protected $redirectTo = '/';

    protected $redirectAfterLogout = '/';

    protected $guestMiddleware = 'guest:user';

    protected $loginView = 'auth.login';

    public function __construct()
    {
        parent::__construct();
    }
}