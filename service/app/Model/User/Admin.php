<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
   
    protected $table = 'admin';
    public function user(){
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }
   
}
