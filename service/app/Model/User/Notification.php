<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   
    protected $table = 'user_notifications';
    public function user(){
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }
   
}
