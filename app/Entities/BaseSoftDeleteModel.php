<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class BaseSoftDeleteModel extends BaseModel
{
    use SoftDeletes;
}
