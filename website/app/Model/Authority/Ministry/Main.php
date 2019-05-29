<?php

namespace App\Model\Authority\Ministry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{	
	use SoftDeletes;
    protected $table = 'ministry';

 
    public function roads() {//1-M
        return $this->hasMany('App\Model\Authority\Ministry\Road', 'ministry_id');
    }

    public function mRoads() {//M-M
        return $this->belongsToMany('App\Model\Road\Main', 'ministries_roads', 'ministry_id', 'road_id');
    }

    public function mos() {//1-M
        return $this->hasMany('App\Model\Authority\MO\Ministry', 'ministry_id');
    }

    public function mMos() {//M-M
        return $this->belongsToMany('App\Model\Authority\MO\Main', 'mos_ministries', 'ministry_id', 'mo_id');
    }

    public function mts(){
        return $this->hasManyThrough('App\Model\Authority\MT\MO', 'App\Model\Authority\MO\Main', 'ministry_id', 'mo_id');
    }

}
