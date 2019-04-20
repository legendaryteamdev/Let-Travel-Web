<?php

namespace App\Model\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use App\Model\LatLngScope; 

class Province extends Model
{
   	use SoftDeletes;
    use SpatialTrait;

    protected $table = 'province';
    // protected static function boot()
    // {
    //     parent::boot();
    //     //static::addGlobalScope(new LatLngScope);
    // }

    protected $fillable = [
        'central',
    ];
     protected $spatialFields = [
        'central',
    ];

    public function mts(){
        return $this->hasMany('App\Model\MT\Main', 'province_id');
    }

    public function mRoads() {
        return $this->hasMany('App\Model\Road\Province', 'province_id');
    }
    public function roads(){
        return $this->belongsToMany('App\Model\Road\Main', 'roads_provinces', 'province_id', 'road_id');
    }

    public function districts() {
        return $this->hasMany('App\Model\Location\District', 'province_id');
    }

    public function communes() {
        return $this->hasManyThrough('App\Model\Location\Commune', 'App\Model\Location\District', 'province_id', 'district_id', 'id', 'id');
    }

    // public function scopeWithLatLng($query){

    //     return $query->selectRaw('created_at ');
    // }
    
}
