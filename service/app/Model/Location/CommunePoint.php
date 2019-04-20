<?php

namespace App\Model\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunePoint extends Model
{
   	use SoftDeletes;

    protected $table = 'communes_points';
    public function commune() {
        return $this->belongsTo('App\Model\Location\Commune', 'commune_id');
    }

    public function point() {
        return $this->belongsTo('App\Model\Road\Point', 'point_id');
    }
    
}
