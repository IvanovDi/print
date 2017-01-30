<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Backend\Repositories\Criteries\SortUsers;
use Modules\Frontend\Repositories\UserRepository;

class UserController extends BaseBackendController
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->repository->with(['companies'])->pushCriteria(new SortUsers($request->get('type')))->all();

        return $this->view('user.index', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = $this->repository->find($id);
        if ($user->is_company) {
            $user->load('employees');
        } else {
            $user->load('companies');
        }

        return $this->view('user.show', [
            'user' => $user,
        ]);
    }

    public function loginAsUser($id)
    {
        \Auth::guard('user')->loginUsingId($id);

        return redirect()->route('frontend.main');
    }
}