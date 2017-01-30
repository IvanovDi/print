<?php

namespace Modules\Frontend\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Modules\Frontend\Entities\Invitation;

class InvitationRepository extends Repository//todo extends from BaseRepository
{
    public function model()
    {
        return Invitation::class;
    }
}