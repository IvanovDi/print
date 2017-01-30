<?php

namespace App\Repositories\Criteries;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class WithTrashed extends Criteria
{

    public function apply($model, RepositoryInterface $repository)
    {
        $query = $model->withTrashed();
        return $query;
    }
}
