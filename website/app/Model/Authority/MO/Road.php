<?php

namespace App\Model\Authority\MO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Road extends Model
{	
	//use SoftDeletes;
    protected $table = 'mos_roads';


    public function mo() {//M-1
        return $this->belongsTo('App\Model\Authority\MO\Main', 'mo_id');
    }

    public function road(){//M-1
        return $this->belongsTo('App\Model\Road\Main', 'road_id');
    }

}
