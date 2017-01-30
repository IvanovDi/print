<?php

namespace Modules\Frontend\Http\Controllers;

use App\Components\GenerateToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Frontend\Entities\User;
use Modules\Frontend\Notifications\ChangeEmailNotification;
use Modules\Frontend\Notifications\ChangePasswordNotification;
use Modules\Frontend\Repositories\UserRepository;

class AccountController extends BaseFrontendController
{
    use GenerateToken;

    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function edit()
    {
        $this->setNotificationAboutEmail();
        $this->setNotificationAboutPassword();

        return $this->view('account.edit', [
            'currentUser' => $this->getCurrentUser(),
        ]);
    }

    public function showEmailChangeForm(Request $request)
    {
        $user = User::where('email_confirm_token', $request->get('token'))
            ->where('id', $this->getCurrentUserId())->first(); //change email can only logined users

        $this->checkIfNull($user, null, function () {
            \Message::warning(['This link has expired']);
        });

        return $this->view('account.confirm_password');
    }

    public function changeEmail(Request $request)
    {
        $this->validate($request, [
            'new_email' => 'required|email|unique:users,email',//todo validation on new_email
        ]);
        if (!$this->getCurrentUser()->email_confirm) {
            \Message::error(['Error']);
        } else {
            $token = $this->generateToken();
            $data = [
                'new_email' => $request->get('new_email'),
                'email_confirm_token' => $token,
            ];
            $this->repository->update($data, $this->getCurrentUserId());
            $this->getCurrentUser()->notify(new ChangeEmailNotification($token));
            \Message::success(['Check your mail.']);
        }
        return redirect()->back();
    }

    public function confirmPassword(Request $request)
    {
        if (Hash::check($request->get('password'), $this->getCurrentUser()->password)) {
            $this->repository->update([
                'email' => $this->getCurrentUser()->new_email,
                'new_email' => null,
                'email_confirm_token' => null,
            ], $this->getCurrentUserId());
            \Message::success(['Email successfully changed.']);
            return redirect()->route('frontend.main');
        } else {
            \Message::error(['Wrong password.']);
            return redirect()->back();
        }

    }

    public function sendEmailChangePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed|different:old_password',
            'password_confirmation' => 'required',
        ]);
        if (Hash::check($request->get('old_password'), $this->getCurrentUser()->password)) {
            $token = $this->generateToken();
            $this->repository->update([
                'new_password' => bcrypt($request->get('password')),
                'password_token' => $token,
            ], $this->getCurrentUserId());
            $this->getCurrentUser()->notify(new ChangePasswordNotification($token));

            \Message::success(['Check email']);
        } else {
            \Message::error(['Wrong password']);
        }

        return redirect()->back();
    }

    public function confirmChangePassword(Request $request)
    {
        if ($this->getCurrentUser()->password_token == $request->get('token')) {
            $this->repository->update([
                'password' => $this->getCurrentUser()->new_password,
                'new_password' => null,
                'password_token' => null,
                'remember_token' => str_random(60),
            ], $this->getCurrentUserId());
            \Message::success(['Password successfully changed.']);
        } else {
            \Message::warning(['This link has expired.']);
        }
        return redirect()->route('frontend.main');
    }

    public function cancelChangeEmail()
    {
        $this->repository->update([
            'new_email' => null,
            'email_confirm_token' => null,
        ], $this->getCurrentUserId());

        return redirect()->route('frontend.main');
    }

    public function cancelChangePassword()
    {
        $this->repository->update([
            'new_password' => null,
            'password_token' => null,
        ], $this->getCurrentUserId());

        return redirect()->route('frontend.main');
    }

    protected function setNotificationAboutEmail()
    {
        $user = $this->getCurrentUser();
        if ($user->new_email && $user->email_confirm_token) {
            \Message::warning(['<form action="' . route('frontend.account.cancelChangeEmail') . '" type="post" style="display: inline-block"><button class="btn btn-link">Cancel</button></form> I don\'t want to change my email.']);
        }
    }

    protected function setNotificationAboutPassword()
    {
        $user = $this->getCurrentUser();
        if ($user->new_password && $user->password_token) {
            \Message::warning(['<form action="' . route('frontend.account.cancelChangePassword') . '" type="post" style="display: inline-block"><button class="btn btn-link">Cancel</button></form> I don\'t want to change my password.']);
        }
    }

    public function resendEmailConfirm()
    {
        $user = $this->getCurrentUser();
        $user->email_confirm_token = $this->generateToken();
        $user->save();
        $user->sendEmailConfirmNotification();
        \Message::success(['Link successfully resented.']);

        return redirect()->back();
    }
}