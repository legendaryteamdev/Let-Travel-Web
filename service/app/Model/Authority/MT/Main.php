<?php

namespace App\Model\Authority\MT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{	
	use SoftDeletes;
    protected $table = 'mt';

    public function user(){
        return $this->belongsTo('App\Model\User\Main', 'user_id');
    }

    public function province(){
        return $this->belongsTo('App\Model\Location\Province', 'province_id');
    }

    public function mos() { //1-M
        return $this->hasMany('App\Model\Authority\MT\MO', 'mt_id');
    }
    public function mMos(){ //M-M
        return $this->belongsToMany('App\Model\Authority\MO\Main', 'mts_mos', 'mt_id', 'mo_id');
    }

    public function roads() { //1-M
        return $this->hasMany('App\Model\Authority\MT\Road', 'mt_id');
    }

    public function mRoads() { //M-M
        return $this->belongsToMany('App\Model\Road\Main', 'mts_roads', 'mt_id', 'road_id');
    }

}
