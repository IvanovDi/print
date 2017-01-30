<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;

class AddonOption extends Model
{
    const MAX_PRICE_SIZE = 99999;

    protected $fillable = [
        'name',
        'price',
        'addon_id',
    ];
}
