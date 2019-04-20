<?php

namespace App\Model\Setting\Maintence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
   	use SoftDeletes;
    protected $table = 'maintences_type';

    public function codes(){
        return $this->hasMany('App\Model\Setting\Maintence\Main', 'type_id');
    }
    
}
