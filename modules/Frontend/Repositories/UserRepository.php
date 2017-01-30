<?php

namespace Modules\Frontend\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Modules\Frontend\Entities\User;

class UserRepository extends Repository//todo extends from BaseRepository
{
    public function model()
    {
        return User::class;
    }
}