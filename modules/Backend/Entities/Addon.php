<?php

namespace Modules\Backend\Entities;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO = 'radio';
    const TYPE_SELECT = 'select';

    public static $displayTypes = [
        self::TYPE_CHECKBOX => 'Checkbox',
        self::TYPE_RADIO => 'Radio',
        self::TYPE_SELECT => 'Select',
    ];
    protected $fillable = [
        'name',
        'type_views',
    ];

    public function options()
    {
        return $this->hasMany(AddonOption::class);
    }

}
