<?php

namespace Modules\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Modules\Backend\Http\Controllers\BaseBackendTrait;

class AdminLoginController extends LoginController
{
    use BaseBackendTrait;

    protected $redirectTo = 'admin';

    protected $redirectAfterLogout = 'admin';

    protected $guestMiddleware = 'guest:admin';

    protected $loginView = 'auth.login';

    public function __construct()
    {
        parent::__construct();
    }
}