<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseModuleController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

abstract class LoginController extends BaseModuleController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $guestMiddleware = 'guest';

    protected $loginView = 'login';

    protected $redirectAfterLogout = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware, ['except' => 'logout']);
    }

    protected function guard()
    {
        return \Auth::guard($this->getGuard());
    }

    public function showLoginForm()
    {
        return $this->view($this->loginView);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

//        $request->session()->flush();todo this logout users from all guards

//        $request->session()->regenerate();

        return redirect($this->redirectAfterLogout);
    }
}