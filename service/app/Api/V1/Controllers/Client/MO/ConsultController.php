<?php

namespace App\Api\V1\Controllers\Client\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Consult as Consult;

class ConsultController extends ApiController
{
    use Helpers;

    function create(Request $request, $potholeId){
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [ 
            'comment'             => 'required|max:500'

        ], [
            'comment.required'         =>  'Please write down your concern',
            'comment.max'               =>  'You are able to up to 500 charactors only.'


        ]);

        $pothole = Pothole::find($potholeId);  
        if($pothole){
            
            //Create Staus
            $consult             = new Consult; 
            $consult->pothole_id  = $potholeId; 
            $consult->comment    = $request->input('comment'); 
            $consult->creator_id = $user->id; 
            $consult->updater_id = $user->id; 
            $consult->save();

            return response()->json([
                'consult'       =>  $consult, 
                'status_code'   =>  200,
                'message'       =>'consult updated'
            ], 200);

        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid pothole']]
            ], 403);
        }
    }


    
}
