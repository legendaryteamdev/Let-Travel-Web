<?php

namespace App\Model\Authority\MT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{	
	use SoftDeletes;
    protected $table = 'mt_actions';


    public function mt() {
        return $this->belongsTo('App\Model\Authority\MT\Main', 'mt_id');
    }

    public function assigner() {
        return $this->belongsTo('App\Model\Authority\MO\Main', 'assigner_id');
    }

    public function potholes() {
        return $this->hasMany('App\Model\Pothole\Main', 'action_id');
    }

}
