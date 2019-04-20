<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{	
	use SoftDeletes;
    protected $table = 'admin';

    public function user(){
        return $this->belongsTo('App\Model\User\Main', 'user_id');
    }
    

}
