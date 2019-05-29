<?php

namespace App\Model\Authority\MO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ministry extends Model
{	
	//use SoftDeletes;
    protected $table = 'mos_ministries';


    public function mo() {//M-1
        return $this->belongsTo('App\Model\Authority\MO\Main', 'mo_id');
    }

    public function ministry() {//M-1
        return $this->belongsTo('App\Model\Authority\Ministry\Main', 'ministry_id');
    }

}
