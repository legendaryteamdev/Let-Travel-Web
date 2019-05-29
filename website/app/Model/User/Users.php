<?php

namespace App\Model\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Users extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
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

    public function logs(){
        return $this->hasMany('App\Model\User\Log', 'user_id');
    }
    public function sendPasswordResetNotification($token) {
        //echo $token; die;
        // do your callback here
        //echo "sendPasswordResetNotification in user model"; die;
        //$this->notify(new ResetPasswordNotification($token));
    }
    
}
