<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
   
    protected $table = 'user_verified_codes';
    public function user(){
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }
   
}
