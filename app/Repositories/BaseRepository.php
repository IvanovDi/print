<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

abstract class BaseRepository extends Repository
{
    public function orderBy(...$data)
    {
        $this->model = $this->model->orderBy(...$data);
        return $this;
    }
}