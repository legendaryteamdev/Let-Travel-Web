<?php

namespace App\Model\Setting\Maintence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
   	use SoftDeletes;
    protected $table = 'maintences_group';

    public function codes(){
        return $this->hasMany('App\Model\Setting\Maintence\Main', 'group_id');
    }
    
}
