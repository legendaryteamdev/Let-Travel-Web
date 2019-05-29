<?php

namespace App\Model\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Village extends Model
{
   	use SoftDeletes;
    use SpatialTrait;

    protected $table = 'village';

    protected $fillable = [
        'central',
    ];
     protected $spatialFields = [
        'central',
    ];

    public function commune() {
        return $this->belongsTo('App\Model\Location\Commune', 'commune_id');
    }

    
}
