<?php

namespace App\Entities;

use App\Notifications\ConfirmEmailNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BaseUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendEmailConfirmNotification()
    {
        $this->notify(new ConfirmEmailNotification($this->email_confirm_token, 'frontend'));
    }
}
