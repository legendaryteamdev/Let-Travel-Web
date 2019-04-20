<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
   
    protected $table = 'users_type';
    public function users(){
        return $this->hasMany('App\Model\User\User', 'type_id');
    }
   
}
