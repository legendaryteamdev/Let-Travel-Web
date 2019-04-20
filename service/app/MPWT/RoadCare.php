<?php

namespace App\MPWT;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\MPWT\LatLngUMTConvert; 

use App\Model\Location\Village; 
use App\Model\Location\Commune;
use App\Model\Location\District;
use App\Model\Location\Province;

use App\Model\Road\Main as Road;
use App\Model\Road\Point as PKPoint;
use App\Model\Pothole\Main as Pothole;

class RoadCare extends Controller
{
    //===========================================================================>> Location
    public static function getLocation($lat = 0, $lng = 0){
        
        //For commune
        $commune = RoadCare::getCommuneByLL($lat, $lng);

        $data = [];
        if($commune){
            $data['commune'] = $commune; 
           

            $data['district'] = $commune['district']; 
            $data['province'] = $commune['district']['province']; 

            unset($data['commune']['district']);
            unset($data['district']['province']);

            if($commune->n_of_villages > 0){
                $village = RoadCare::fetchNearestVillage($lat, $lng, 1000, $commune->id);
                if($village){
                    $data['village'] = $village;
                }
            }
        }
        return $data; 
    }


    public static function villageNearBy($lat, $lng, $r = 0, $communeId){
       
            
            $utm = LatLngUMTConvert::ll2utm($lat, $lng); 
            $data = Village::select(
                'id', 'name', 'code', 'commune_id', 'lat', 'lng',
                DB::raw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
            ->with([
                'commune:id,name,code,district_id', 
                'commune.district:id,name,code,province_id', 
                'commune.district.province:id,name,code'
            ]); 

            if($r != 0){
                $data = $data->whereRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r);
            }
            

            $data = $data->orderBy('distance', 'ASC')->limit(100)->get(); 
            return $data; 

       
    }

    public static function fetchNearestVillage($lat = 0, $lng = 0, $statingR = 1000, $communeId = 0){
        if($statingR <= 10000){

            $data = self::villageNearBy($lat, $lng, $statingR, $communeId);
            if(count($data) == 0){
                $statingR += 1000; 
                return self::fetchNearestVillage($lat, $lng, $statingR, $communeId);
            }else{
                return $data[0]; 
            }

        }else{
            return []; 
        }
           
    }

    public static function communeNearBy($lat, $lng, $r = 0, $districtId = 0){
        $utm = LatLngUMTConvert::ll2utm($lat, $lng); 
        $data = Commune::select(
            'id', 'name', 'code', 'district_id', 'lat', 'lng',
            DB::raw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
        ->whereRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)
        ->with([
            'district:id,name,code,province_id', 
            'district.province:id,name,code'
        ])->withCount(['villages as n_of_villages']); 
        
        if($districtId != 0){
            $data = $data->where('district_id', 'ASC'); 
        }

        $data = $data->orderBy('distance', 'ASC')->limit(100)->get(); 

        return $data; 
    }
    
    public static function fetchNearestCommune($lat = 0, $lng = 0, $statingR = 1000){
        $data = self::communeNearBy($lat, $lng, $statingR);
        if(count($data) == 0){
            $statingR += 1000; 
            return self::fetchNearestCommune($lat, $lng, $statingR);
        }else{
            return $data[0]; 
        }
    }

    public static function getCommuneByLL($lat, $lng){
        $utm = LatLngUMTConvert::ll2utm($lat, $lng); 
        $data = Commune::select(
            'id', 'name', 'code', 'district_id', 'lat', 'lng',
            DB::raw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
        ->whereRaw("ST_Contains(`boundary`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) = 1")
        ->with([
            'district:id,name,code,province_id', 
            'district.province:id,name,code'
        ])->withCount(['villages as n_of_villages'])->first(); 
        return $data; 
    }

    public static function getVillagesByLL($lat = 0, $lng = 0, $r = 10000){
        $utm = LatLngUMTConvert::ll2utm($lat, $lng); 

        $village = Village::select(
            'id', 'name', 'code', 'commune_id', 
            DB::raw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
        ->whereRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)
        ->orderBy('distance', 'ASC')->limit(3)->get(); 

        return $village; 
    }

     /**
     * Get 
     *
     * @param   Decimal $lat 
     * @param   Decimal $lng
     * @return array of a road owith first part with first pk with nearest point
     */
    // public static function nrNearBy($lat = 0, $lng = 0, $r = 0){
    //     $utm = LatLngUMTConvert::ll2utm($lat, $lng);

    //     $nrs = Road::select('id', 'name', 'start_point', 'end_point')
    //     ->with(['parts'=>function($query) use ($utm, $r){
    //         $query->select('id', 'road_id', 'type_id')->whereHas('pks', function($query) use ($utm, $r){
    //             $query->whereHas('points', function($query) use ($utm, $r){
    //                 $query->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r); 
    //             });
    //         })->with(['type:id,name', 'pks'=>function($query) use ($utm, $r){
    //             $query->select('id', 'part_id', 'code')->wherehas('points', function($query) use($utm, $r){
    //                 $query->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r);
    //             })->with(['points'=>function($query) use ($utm, $r){
    //                 $query->select('id', 'pk_id', 'meter', 'point', DB::raw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
    //                 ->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)->orderBy('distance', 'ASC')
    //                 ->first();//first point
    //             }])->first();//first PK
    //         }])->first(); //first part
    //     }])
    //     ->whereHas('parts', function($query) use ($utm, $r){
    //         $query->whereHas('pks', function($query) use ($utm, $r){
    //             $query->whereHas('points', function($query) use ($utm, $r){
    //                 $query->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r); 
    //             });
    //         });
    //     })->get(); 

    //     return $nrs; 
    // }


    //===========================================================================>> National Road
    public static function getRoad($lat = 0, $lng = 0){
        $lat = llformat($lat, 5); 
        $lng = llformat($lng, 5);
        return self::pointSearching($lat, $lng);
    }

     /**
     * Get 
     *
     * @param   Decimal $lat 
     * @param   Decimal $lng
     * @return array of a point on a PK of a Part of a natioanl road
     */
    public static function pointNearBy($lat = 0, $lng = 0, $r = 0){
        $utm = LatLngUMTConvert::ll2utm($lat, $lng);
        $point = PKPoint::select('id', 'pk_id', 'meter', 'point', DB::raw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
        ->with([
            'pk:id,code,road_id', 
            'pk.road:id,name,start_point,end_point,migrate_method',
        ])
        ->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)
        ->orderBy('distance', 'ASC')->limit(100)->get();

        return $point; 
    }

    public static function pointSearching($lat = 0, $lng = 0, $statingR = 10){
        if( $statingR <= 100 ){
            $data = self::pointNearBy($lat, $lng, $statingR);
            if(count($data) == 0){
                $statingR += 10; 
                return self::pointSearching($lat, $lng, $statingR);
            }else{
                return $data[0]; 
            }
        }else{
            return []; 
        } 
    }

     /**
     * Get 
     *
     * @param   Decimal $lat 
     * @param   Decimal $lng
     * @return 
     */
    public static function potholeNearBy($lat = 0, $lng = 0, $r = 10){
        $utm = LatLngUMTConvert::ll2utm($lat, $lng); 

        $potholes = Pothole::select(
            'id', 'created_at'
        )->distinct()
        ->withCount(['reports as n_of_reports'])
        ->with([
            'reports'=>function($query) use ($utm){
                $query->select( 'id', 'member_id', 'pothole_id', 'description', 'lat', 'lng', 
                    //'point', 
                    DB::raw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
                ->with([
                // 'ru:id,user_id',
                // 'ru.user:id,name,avatar',
                    'files:id,uri,lat,lng,report_id'
                ])->orderBy('id', 'DESC'); 
            }, 
            'statuses'=>function($query){
                $query->select('id', 'pothole_id', 'status_id', 'updater_id', 'updated_at', 'comment')
                ->with([
                    'status:id,name', 
                    'updater:id,name,avatar'
                ])
                ->orderBy('id', 'DESC')->get(); 
            }, 
            'location'=>function($query) use ($utm){
                $query->select(
                    'id', 'pothole_id', 'village_id', 'commune_id', 'district_id', 'province_id', 'lat', 'lng',
                    DB::raw("ST_Distance(`points`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance")
                )->with([
                    'village:id,name,code', 
                    'commune:id,name,code', 
                    'district:id,name,code', 
                    'province:id,name,code', 
                ]);
            }
        ])->whereHas('location', function($query) use ($utm, $r){
            $query->whereRaw("ST_Distance(`points`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r); 
        })
        ->limit(100)->get();
        return $potholes; 
    }

    public static function potholeSearching($lat = 0, $lng = 0, $statingR = 10){
        $data = self::potholeNearBy($lat, $lng, $statingR);
        if(count($data) == 0){
            $statingR += 10; 
            return self::potholeSearching($lat, $lng, $statingR);
        }else{
            return $data[0]; 
        }
    }


  


}
