<?php

namespace App\Model\Authority\MO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{	
	use SoftDeletes;
    protected $table = 'mo';

    public function user(){ //1-1
        return $this->belongsTo('App\Model\User\Main', 'user_id');
    }

    public function ministries() { //1-M
        return $this->hasMany('App\Model\Authority\MO\Ministry', 'mo_id');
    }

    public function mMinistries() { //M-M
        return $this->belongsToMany('App\Model\Authority\Ministry\Main', 'mos_ministries', 'mo_id', 'ministry_id');
    }
    
    public function roads() { //1-M
        return $this->hasMany('App\Model\Authority\MO\Road', 'mo_id');
    }

    public function mRoads() { //M-M
        return $this->belongsToMany('App\Model\Road\Main', 'mos_roads', 'mo_id', 'road_id');
    }

    public function mts() { //1-M
        return $this->hasMany('App\Model\Authority\MT\MO', 'mo_id');
    }

    public function mMts() {//M-M
        return $this->belongsToMany('App\Model\Authority\MT\Main', 'mts_mos', 'mo_id', 'mt_id');
    }

    public function assigns() { //1-M
        return $this->hasMany('App\Model\Authority\MT\Action', 'assigner_id');
    }

}
