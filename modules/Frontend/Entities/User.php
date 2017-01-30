<?php

namespace Modules\Frontend\Entities;

use App\Entities\BaseUser;
use App\Notifications\ResetPasswordNotification;

class User extends BaseUser
{
    protected $casts = [
        'is_company' => 'boolean',
        'email_confirm' => 'boolean',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'email_confirm_token', 'email_confirm', 'is_company', 'company_name',
        'first_name', 'last_name', 'address', 'phone', 'fax', 'web', 'new_email', 'new_password', 'password_token',
    ];

    protected $appends = [
        'company_real_name',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, 'frontend'));
    }

    public function confirmEmail()
    {
        $this->email_confirm = true;
        $this->email_confirm_token = null;
        $this->save();
    }

    public function companies()
    {
        return $this->belongsToMany(User::class, 'company_user', 'user_id', 'company_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'user_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'company_id');
    }

    public function getCompanyRealNameAttribute()
    {
        return ($this->company_name) ? $this->company_name : $this->email;
    }
}