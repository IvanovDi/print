<?php

namespace App\Http\Controllers\Auth;

use App\Components\GenerateToken;
use App\Http\Controllers\BaseModuleController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

abstract class RegisterController extends BaseModuleController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers, GenerateToken;

    /**
     * Where to redirect users after login / registration.
     *
     * @var strings
     */
    protected $redirectTo = '/home';

    protected $guestMiddleware = 'guest';

    protected $needEmailConfirm = false;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware, [
            'except' => [
                'confirmEmail',
            ]
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    abstract protected function validator(array $data);

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     */
    abstract protected function create(array $data);

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return $this->view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($this->needEmailConfirm) {
            $user->sendEmailConfirmNotification();
        }
        $this->guard()->login($user);

        $this->actionAfterLogin();

        return redirect($this->redirectPath());
    }

    protected function actionAfterLogin()
    {
        //
    }


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard($this->getGuard());
    }
}