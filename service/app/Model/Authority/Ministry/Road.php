<?php

namespace App\Model\Authority\Ministry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Road extends Model
{	
	//use SoftDeletes;
    protected $table = 'ministries_roads';


    public function ministry() { //M-1
        return $this->belongsTo('App\Model\Authority\Ministry\Main', 'ministry_id');
    }

    public function road() { //M-1
        return $this->belongsTo('App\Model\Road\Main', 'road_id');
    }

}
