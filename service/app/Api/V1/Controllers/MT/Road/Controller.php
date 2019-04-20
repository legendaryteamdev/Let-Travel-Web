<?php

namespace App\Api\V1\Controllers\MT\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Authority\MT\Road as Road;
use App\Model\Authority\MT\Main as MT;

class Controller extends ApiController
{
    use Helpers;
    
    function list(){
        $user = JWTAuth::parseToken()->authenticate();
        $mt = MT::select('id')->where('user_id', $user->id)->first(); 
        
        $data      =    Road::select('id', 'mt_id', 'road_id', 'start_pk', 'end_pk')->with(['road:id,name'])->where('mt_id', $mt->id)->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }

   

}
