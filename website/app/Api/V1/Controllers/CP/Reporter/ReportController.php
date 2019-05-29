<?php

namespace App\Api\V1\Controllers\CP\Reporter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User;
use App\Model\Member\Main as Member;
use App\Model\Pothole\Report as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class ReportController extends ApiController
{
    use Helpers;
    function list($id=0){
        $data = Main::select('id', 'pothole_id', 'member_id', 'commune_id', 'description', 'lat', 'lng', 'created_at')
        ->with(['pothole:id,code,point_id', 'pothole.point'=>function($query){
            $query->select('id', 'pk_id')->with(['point.pk:id,code,road_id', 'point.pk.road:id,name,start_point,end_point']); 
        }])
        ->where('member_id',$id)->orderBy('id', 'desc')->get(); 
        return response()->json($data, 200);
    }

    function view($id=0){
        $data = Main::select('*')->findOrFail($id);
        if($data){
            return response()->json(['data'=>$data], 200);
        }else{
            return response()->json(['status_code'=>404], 404);
        }
    }

}
