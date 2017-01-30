<?php

namespace Modules\Backend\Repositories\Criteries;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class FindByRelation extends Criteria
{
    protected $optionId;
    protected $relation;

    public function __construct($relation, $optionId)
    {
        $this->optionId = $optionId;
        $this->relation = $relation;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas($this->relation, function ($query) {
            $query->where('id', $this->optionId);
        });
    }
}
