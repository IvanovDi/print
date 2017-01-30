<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Frontend\Repositories\UserRepository;

class ProfileController extends BaseFrontendController
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function edit()
    {
        if (!$this->getCurrentUser()->is_company) {
            $companies = $this->getCurrentUser()->companies()->get();
        } else {
            $companies = [];
        }

        return $this->view('profile.edit', [
            'currentUser' => $this->getCurrentUser(),
            'companies' => $companies,
        ]);
    }

    public function update(Request $request)
    {
        $this->repository->update($request->except([
            '_token',
        ]), $this->getCurrentUserId());

        \Message::success(['Profile successfully updated.']);

        return redirect()->back();
    }

    public function showNotifications()
    {
        $notifications = $this->getCurrentUser()->notifications()->paginate(20);
        $this->getCurrentUser()->unReadNotifications->markAsRead();
        \NotificationCache::destroyCache();

        return $this->view('profile.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsReadAllNotifications()
    {
        \NotificationCache::destroyCache();
        $this->getCurrentUser()->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
