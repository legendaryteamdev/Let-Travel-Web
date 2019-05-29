<?php

namespace App\Model\Authority\MT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MO extends Model
{	
	use SoftDeletes;
    protected $table = 'mts_mos';


    public function mt() {
        return $this->belongsTo('App\Model\Authority\MT\Main', 'mt_id');
    }

    public function mo() {
        return $this->belongsTo('App\Model\Authority\MO\Main', 'mo_id');
    }

}
