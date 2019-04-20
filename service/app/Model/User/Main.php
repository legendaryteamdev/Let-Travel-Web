<?php

namespace App\Model\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Authenticatable
{
    use Notifiable;
    //use SoftDeletes;
    protected $table = 'user';
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
        'password', 'remember_token', 'password', 'google2fa_secret', 'telegram_chat_id', 'social_id', 'app_token'
    ];
   
   

    public function type() {
        return $this->hasMany('App\Model\User\Type', 'type_id');
    }

    public function logs() {
        return $this->hasMany('App\Model\User\Log', 'user_id');
    }


    public function admin() {
        return $this->hasOne('App\Model\User\Admin', 'user_id');
    }
    public function mo() {
        return $this->hasOne('App\Model\Authority\MO\Main', 'user_id');
    }
    public function mt() {
        return $this->hasOne('App\Model\Authority\MO\Main', 'user_id');
    }
    public function ru() {
        return $this->hasOne('App\Model\Member\Main', 'user_id');
    }

    
    public function comments() {
        return $this->hasMany('App\Model\Pothole\Comment', 'creator_id');
    }
   
   

}
