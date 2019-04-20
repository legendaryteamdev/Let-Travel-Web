<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'user';

    protected $hidden = [
        'password', 'remember_token', 'password', 'google2fa_secret', 'telegram_chat_id', 'social_id'
    ];

    public function admin() {
        return $this->hasOne('App\Model\User\Admin', 'user_id');
    }
    public function mo() {
        return $this->hasOne('App\Model\Authority\MO\Main', 'user_id');
    }
    public function mt() {
        return $this->hasOne('App\Model\Authority\MT\Main', 'user_id');
    }
    public function ru() {
        return $this->hasOne('App\Model\Member\Main', 'user_id');
    }

}
