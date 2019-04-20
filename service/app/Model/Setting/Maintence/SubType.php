<?php

namespace App\Model\Setting\Maintence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubType extends Model
{
   	use SoftDeletes;
    protected $table = 'maintences_subtype';

    public function codes(){
        return $this->hasMany('App\Model\Setting\Maintence\Main', 'subtype_id');
    }
    
}
