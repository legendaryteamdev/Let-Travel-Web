<?php

namespace App\Model\Authority\MT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Road extends Model
{	
	//use SoftDeletes;
    protected $table = 'mts_roads';


    public function mt() {//M-1
        return $this->belongsTo('App\Model\Authority\MT\Main', 'mt_id');
    }

    public function road(){//M-1
        return $this->belongsTo('App\Model\Road\Main', 'road_id');
    }

}
