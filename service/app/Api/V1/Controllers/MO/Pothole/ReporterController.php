<?php

namespace App\Api\V1\Controllers\MO\Pothole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Report as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class ReporterController extends ApiController
{
    use Helpers;
    function list($id=0){
        $data = Main::select('id', 'pothole_id', 'member_id', 'commune_id', 'description', 'lat', 'lng', 'created_at')
        ->with([
            'ru:id,user_id',
            'ru.user:id,name,phone,avatar,email', 
            'files:id,report_id,uri,lat,lng', 
            'comments'=>function($query){
                        $query->select('id', 'report_id', 'creator_id', 'comment', 'created_at')
                        ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
                    }, 
            
        ])
        ->where('pothole_id',$id)->orderBy('id', 'desc')->get(); 
        return response()->json($data, 200);
    }

    function view($id=0,$report_id=0){
        $data = Main::select('*')->findOrFail($report_id);
        if($data){
            return response()->json(['data'=>$data], 200);
        }else{
            return response()->json(['status_code'=>404], 404);
        }
    }

   

    


}
