<?php

namespace App\Api\V1\Controllers\MT\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main;
use App\Model\Authority\MT\Main as MT;
use App\Model\Authority\MT\Road as Road;

use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){
        $user = JWTAuth::parseToken()->authenticate();
        $mt = MT::select('id')->where('user_id', $user->id)->first(); 

        $data = Main::select('id', 'user_id', 'description', 'name')->with(['user:id,name,phone,email,avatar']);
        
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->whereHas('user', function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%')->orWhere('phone', 'like', '%'.$key.'%')->orWhere('email', 'like', '%'.$key.'%');
            });
        }
        $data = $data
        ->whereHas('mts', function($query) use ($mt){
            $query->where('mt_id', $mt->id); 
        })
        ->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }


    function view($id = 0){
        if($id!=0){
            $data = Main::select('id', 'user_id', 'description', 'name')->with(['user:id,name,phone,email,avatar'])->withCount('mMos as n_of_mos')->withCount('mRoads as n_of_m_roads')->findOrFail($id);
            if($data){
                return response()->json(['data'=>$data], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

    function roads($mtId=0){
        $data      =    Road::select('id', 'mt_id', 'road_id', 'start_pk', 'end_pk')->with(['road:id,name'])->where('mt_id', $mtId)->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }
   
}
