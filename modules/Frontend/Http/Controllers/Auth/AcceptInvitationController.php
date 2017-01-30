<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\Frontend\Entities\Invitation;
use Modules\Frontend\Entities\User;
use Modules\Frontend\Http\Controllers\BaseFrontendController;
use Modules\Frontend\Notifications\UserAcceptInvitation;

class AcceptInvitationController extends BaseFrontendController
{
    public function __construct()
    {
        $this->middleware('guest:user', [
            'only' => [
                'enterPasswordForInvitationUser',
            ]
        ]);
    }

    public function acceptInvitation(Request $request)
    {
        $invitation = $this->getInvitation($request->get('token'));

        $this->checkIfNull($invitation, 'frontend.main');

        $user = User::where('email', $invitation->email)->first();

        if ($user === null) { // create new user
            if (\Auth::guard($this->getGuard())->check()) {
                return redirect()->route('frontend.main');
            }

            return $this->view('user_management.enter_password', [
                'token' => $request->get('token'),
            ]);
        } else {
            $invitation->company->notify(new UserAcceptInvitation($invitation, true));
            \DB::transaction(function () use ($user, $invitation, $request) {
                if ($request->has('notification_id')) {
                    $notification = $user->notifications()->where('id', $request->get('notification_id'))->first();
                } else {
                    $notification = $user->notifications()->where('data->token', $request->get('token'))->first();
                }

                if ($notification !== null) {
                    $notification->markAsRead();
                    \NotificationCache::destroyCache($this->getCurrentUserId());
                }
                if (!$user->email_confirm) {
                    $user->email_confirm = true;
                    $user->email_confirm_token = true;
                    $user->save();
                }
                $user->companies()->attach($invitation->company_id);
                $this->setInvitationActive($invitation, $user->id);
            });

            \Auth::guard($this->getGuard())->login($user);
            return redirect()->route('frontend.profile.edit');
        }
    }

    public function enterPasswordForInvitationUser(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $invitation = $this->getInvitation($request->get('token'));
        $this->checkIfNull($invitation, 'frontend.main');
        $invitation->company->notify(new UserAcceptInvitation($invitation, true));
        \DB::transaction(function () use ($invitation, $request) {
            $user = User::create([
                'email' => $invitation->email,
                'password' => bcrypt($request->get('password')),
                'email_confirm' => true,
                'is_company' => false,
            ]);

            $user->companies()->attach($invitation->company_id);
            $this->setInvitationActive($invitation, $user->id);
            \Auth::guard($this->getGuard())->login($user);
        });

        return redirect()->route('frontend.profile.edit');
    }

    public function declineInvitation(Request $request)
    {
        $invitation = Invitation::where('token', $request->get('token'))
            ->where('is_active', false)
            ->with('company')
            ->first();

        $this->checkIfNull($invitation);
        $invitation->company->notify(new UserAcceptInvitation($invitation, false));
        $invitation->delete();
        $notification = $this->getCurrentUser()->notifications()->where('id', $request->get('notification_id'))->first();
        $this->checkIfNull($notification);
        $notification->markAsRead();
        \NotificationCache::destroyCache($this->getCurrentUserId());

        return redirect()->back();
    }

    protected function getInvitation($token)
    {
        return Invitation::where('token', $token)
            ->where('is_active', false)
            ->with('company')
            ->first();
    }

    protected function setInvitationActive($invitation, $userId)
    {
        $invitation->is_active = true;
        $invitation->user_id = $userId;
        $invitation->save();
    }
}