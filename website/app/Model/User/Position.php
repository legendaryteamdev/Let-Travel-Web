<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
   
    protected $table = 'positions';
    public function users() {
        return $this->hasMany('App\Model\User\User');
    }
   
}
