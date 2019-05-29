<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_logs';
    public function user(){
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }
   
}
