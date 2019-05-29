<?php

namespace App\Api\V1\Controllers\CP\Reporter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Member\Main as Member;
use App\Model\Member\Score as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class ScoreController extends ApiController
{
    use Helpers;
    function list($id=0){
        return response()->json(Main::select('*')->where('member_id',$id)->orderBy('id', 'desc')->get(), 200);
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
