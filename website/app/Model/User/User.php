<?php

namespace App\Model\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
    public function position(){
        return $this->belongsTo('App\Model\User\Position');
    }
    // public function properties() {
    //     return $this->hasMany('App\Model\Property\Property', 'creator_id');
    // }

    // public function logs() {
    //     return $this->hasMany('App\Model\User\Log', 'user_id');
    // }

    // public function records() {
    //     return $this->hasMany('App\Model\Mailing\Record', 'creator_id');
    // }
    // public function userPermisions() {
    //     return $this->hasMany('App\Model\User\UserPermision');
    // }
    // public function staffProperties() {
    //     return $this->hasMany('App\Model\Property\PropertyStaff', 'staff_id');
    // }

}
