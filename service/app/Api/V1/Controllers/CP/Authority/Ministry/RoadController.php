<?php

namespace App\Api\V1\Controllers\CP\Authority\Ministry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use DB;

use App\Model\Road\Main as Road;

use App\Model\Authority\Ministry\Road as Main;

class RoadController extends ApiController
{
    use Helpers;
    function search($ministry_id = 0){
    	$data      =    Road::select('id', 'name', 'start_point', 'end_point', 'is_point_migrated', 'length', 'updated_at')
        ->with([
            'provinces:id,road_id,province_id', 
            'provinces.province:id,abbre', 
            'ministries'=>function($query){
                $query->select('ministry_id', 'road_id','start_pk','end_pk')->distinct()
                ->with(['ministry:id,abbre']);
            }
        ])
        ->withCount([
            'mos as n_of_mos', 
            'mts as n_of_mts', 
            'parts as n_of_parts', 
            'pks as n_of_pks'
        ])->whereHas('mMinistries', function ($query) use ($ministry_id) {
            $query->where('ministry_id', $ministry_id);
        }); 

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
       
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%');
            });
            
        }

        $data= $data->orderBy('is_point_migrated', 'desc')->orderBy('name', 'asc')->paginate($limit);
        return response()->json($data, 200);
        
        if($data){
            return response()->json($data, 200);
        }else{
            return response()->json(['status_code'=>404, 'message'=>'Data not found.'], 200);
        }
        
    }


}
