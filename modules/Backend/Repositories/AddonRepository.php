<?php

namespace Modules\Backend\Repositories;


use App\Repositories\BaseRepository;
use Modules\Backend\Entities\Addon;

class AddonRepository extends BaseRepository
{
    public function model()
    {
        return Addon::class;
    }

}