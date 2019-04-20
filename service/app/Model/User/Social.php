<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
   
    protected $table = 'users_social';
    public function users(){
        return $this->hasMany('App\Model\User\User', 'social_type_id');
    }
   
}
