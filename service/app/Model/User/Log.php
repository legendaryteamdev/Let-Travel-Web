<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
   
    protected $table = 'user_logs';
    public function user(){
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }
   
}
