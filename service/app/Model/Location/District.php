<?php

namespace App\Model\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class District extends Model
{
   	use SoftDeletes;
    use SpatialTrait;

    protected $table = 'district';

    protected $fillable = [
        'central',
    ];
     protected $spatialFields = [
        'central',
    ];

    public function province() {
        return $this->belongsTo('App\Model\Location\Province', 'province_id');
    }

    public function communes() {
        return $this->hasMany('App\Model\Location\Commune', 'district_id');
    }
    public function villages() {
        return $this->hasManyThrough('App\Model\Location\Village', 'App\Model\Location\Commune', 'district_id', 'commune_id', 'id', 'id');
    }
}
