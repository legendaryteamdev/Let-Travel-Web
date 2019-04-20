<?php

namespace App\Api\V1\Controllers\MO\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Road\Main as Main;
use App\Model\Authority\MT\Main as MT;

class Controller extends ApiController
{
    use Helpers;
    
    function list(){
        $user = JWTAuth::parseToken()->authenticate();
        $mtId = isset($_GET['mt'])?$_GET['mt']:0; 
      
        $data      =    Main::select('id', 'name', 'start_point', 'end_point')
        ->with(['mts'=>function($query) use ($user, $mtId){
        	$query->select('id', 'road_id', 'start_pk', 'end_pk', 'mt_id')->with(['mt:id,user_id', 'mt.user:id,name'])
        	->whereHas('mt', function($query) use ($user){
        		$query->whereHas('mos', function($query) use ($user){
        			$query->where('mo_id', $user->mo->id); 
        		});
        	});
        	if($mtId != 0){
        		$query->where('mt_id', $mtId); 
        	}
        }])

        ->whereHas('mts', function($query) use ($user, $mtId) {
        	$query->whereHas('mt', function($query) use ($user){
        		$query->whereHas('mos', function($query) use ($user){
        			$query->where('mo_id', $user->mo->id); 
        		});
        	});
        	if($mtId != 0){
        		$query->where('mt_id', $mtId); 
        	}
        })
        ->orderBy('name', 'asc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }

    function mts(){
    	$user = JWTAuth::parseToken()->authenticate();
        $data = MT::select('id', 'user_id')->with(['user:id,name'])->whereHas('mos', function($query) use ($user){
            $query->where('mo_id', $user->mo->id); 
        })->orderBy('id', 'desc')->get();
        return response()->json($data, 200);
    }
   

}
