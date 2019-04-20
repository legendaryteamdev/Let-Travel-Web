<?php

namespace App\Api\V1\Controllers\MT\Dashboard;

use Illuminate\Http\Request;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MT\Main as MT;
use App\Model\Member\Main as Member;
use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Status;
use JWTAuth;

class Controller extends ApiController
{
    //use Helpers;

    function getData(){
        $user = JWTAuth::parseToken()->authenticate();
        $mt = MT::select('id')->where('user_id', $user->id)->first(); 

        $pothole        = Pothole::whereHas('action', function($query) use ($mt){
            $query->where('mt_id', $mt->id); 
        });

        $total = $pothole->count(); 
       
        
        return response()->json([
         
            'total'         => $total
        ], 200);
    }

  
   
}
