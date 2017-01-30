<?php

namespace Modules\Frontend\Http\Controllers;

use App\Components\GenerateToken;
use App\Repositories\Criteries\WithTrashed;
use Illuminate\Http\Request;
use Modules\Frontend\Entities\User;
use Modules\Frontend\Mail\AddNewUserToCompany;
use Modules\Frontend\Notifications\ActivatedDeactivatedUserNotification;
use Modules\Frontend\Notifications\DeleteFromCompanyNotification;
use Modules\Frontend\Notifications\InvitationForCompanyNotification;
use Modules\Frontend\Repositories\InvitationRepository;

class UserManagementController extends BaseFrontendController
{
    use GenerateToken;

    protected $repository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->repository = $invitationRepository;
    }

    public function index()
    {
        $invitations = $this->repository->with(['user'])
            ->pushCriteria(new WithTrashed())
            ->findWhere(['company_id' => $this->getCurrentUserId()]);

        return $this->view('user_management.index', [
            'invitations' => $invitations,
        ]);
    }

    public function sendInvitation(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        $validator->after(function($validator) use ($request) {
            $invitations = $this->getCurrentUser()->invitations()->where('email', $request->get('email'))->first();
            if ($invitations !== null) {
                $validator->errors()->add('email', 'User already invited');
            } else {
                $user = User::where('email', $request->get('email'))->first();
                if ($user !== null && $user->is_company == true) {
                    $validator->errors()->add('email', 'It\'s a company.');
                }
            }
        });
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $this->sendInvitationToUser($request->get('email'));
        \Message::success(['Invitation has been sent successfully.']);

        return redirect()->back();
    }

    public function deactivateUser($id)
    {
        $invitation = $this->repository->with(['user'])->find($id);
        $this->checkIfNull($invitation);

        \DB::transaction(function () use ($invitation, $id) {
            if ($invitation->user !== null) {
                $invitation->user->notify(new DeleteFromCompanyNotification($invitation));
                $invitation->user->companies()->detach($invitation->company_id);
            }
            $invitation->delete($id);
        });
        \Message::success(['User successfully deactivated.']);

        return redirect()->back();
    }

    public function activateUser($id)//restore invitation and add relation user-company
    {
        $invitation = $this->repository->with(['user'])->pushCriteria(new WithTrashed())->find($id);
        $this->checkIfNull($invitation);

        \DB::transaction(function () use ($invitation) {
            $invitation->restore();
            $invitation->user->companies()->attach($invitation->company_id);
            $invitation->user->notify(new ActivatedDeactivatedUserNotification($invitation));
        });
        \Message::success(['User successfully activated.']);

        return redirect()->back();
    }

    public function resendInvitation($id)
    {
        $invitation = $this->repository->find($id);
        $this->checkIfNull($invitation);
        $this->sendInvitationToUser($invitation->email, $id);
        \Message::success(['Invitation successfully resend.']);

        return redirect()->back();
    }

    protected function sendInvitationToUser($email, $invitationId = false)
    {
        $user = User::where('email', $email)->first();
        $data = [
            'email' => $email,
            'token' => $this->generateToken(),
            'user_id' => $user->id ?? null,
        ];

        if ($invitationId !== false) {
            $this->markAsReadPreviousInvitationNotification($user);
            $this->repository->update($data, $invitationId);
            $invitation = $invitationId;
        } else {
            $data['company_id'] = $this->getCurrentUserId();
            $invitation = $this->repository->create($data);
        }
        if ($user !== null) {
            $user->notify(new InvitationForCompanyNotification($invitation));
        }
        \Mail::to($email)->send(new AddNewUserToCompany($data['token']));
    }

    protected function markAsReadPreviousInvitationNotification($user)
    {
        if ($user !== null) {
            $invitationNotification = $user->notifications()
                ->where('type', 'Modules\Frontend\Notifications\InvitationForCompanyNotification')
                ->first();

            if ($invitationNotification !== null) {
                $invitationNotification->markAsRead();
            }
        }
    }

}