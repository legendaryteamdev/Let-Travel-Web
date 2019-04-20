<?php

namespace App\Model\Setting\Maintence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
   	use SoftDeletes;
    protected $table = 'maintences_unit';

    public function codes(){
        return $this->hasMany('App\Model\Setting\Maintence\Main', 'unit_id');
    }
    
}
