<?php

namespace Modules\Frontend\Entities;

use App\Entities\BaseSoftDeleteModel;

class Invitation extends BaseSoftDeleteModel
{
    protected $fillable = [
        'email', 'token', 'is_active', 'company_id', 'user_id',
    ];

    protected $visible = [
        'email', 'token', 'is_active', 'company_id', 'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
