<?php

namespace Modules\Backend\Repositories\Criteries;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class SortUsers extends Criteria
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->type === 'individual') {
            return $model->where('is_company', false);
        } elseif ($this->type === 'corporate') {
            return $model->where('is_company', true);
        } else {
            return $model;
        }
    }
}
