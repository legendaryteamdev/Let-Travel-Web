<?php

namespace App\Model\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Commune extends Model
{
   	use SoftDeletes;
    use SpatialTrait;

    protected $table = 'commune';

    protected $fillable = [
        'central', 'boundary'
    ];
     protected $spatialFields = [
        'central', 'boundary'
    ];

    public function district() {
        return $this->belongsTo('App\Model\Location\District', 'district_id');
    }

    public function villages() {
        return $this->hasMany('App\Model\Location\Village', 'commune_id');
    }
    
}
