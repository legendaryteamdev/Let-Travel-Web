<?php

namespace App\Model\Setting\Maintence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{	
	use SoftDeletes;
    protected $table = 'maintence';

    public function group() { //M-1
        return $this->belongsTo('App\Model\Setting\Maintence\Group', 'group_id');
    }

    public function type() { //M-1
        return $this->belongsTo('App\Model\Setting\Maintence\Type', 'type_id');
    }

    public function subtype() { //M-1
        return $this->belongsTo('App\Model\Setting\Maintence\SubType', 'subtype_id');
    }

    public function unit() { //M-1
        return $this->belongsTo('App\Model\Setting\Maintence\Unit', 'unit_id');
    }

    public function potholes() { //1-M
        return $this->hasMany('App\Model\Pothole\Main', 'maintence_id');
    }
   

}
