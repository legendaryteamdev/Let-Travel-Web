<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class UserPermision extends Model
{
   
    protected $table = 'users_permisions';
    public function user() {
        return $this->belongsTo('App\Model\User\User');
    }
    public function permision() {
        return $this->belongsTo('App\Model\User\Permision');
    }
   
}
