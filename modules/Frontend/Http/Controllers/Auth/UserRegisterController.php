<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Modules\Frontend\Entities\User;
use Modules\Frontend\Http\Controllers\BaseFrontendTrait;

class UserRegisterController extends RegisterController
{
    use BaseFrontendTrait;

    protected $guestMiddleware = 'guest:user';

    protected $redirectTo = '/';

    protected $needEmailConfirm = true;

    public function __construct()
    {
        parent::__construct();
    }

    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_confirm_token' => $this->generateToken(),
            'is_company' => $data['type'] ?? false,
        ]);
    }

    public function redirectPath()
    {
        return route('frontend.profile.edit');
    }

    public function confirmEmail(Request $request)
    {
        User::where('email_confirm_token', $request->get('token'))
            ->where('email_confirm', false)
            ->firstOrFail()->confirmEmail();

        \Message::success(['Email successfully verified.']);

        return redirect()->route('frontend.profile.edit');
    }
}
