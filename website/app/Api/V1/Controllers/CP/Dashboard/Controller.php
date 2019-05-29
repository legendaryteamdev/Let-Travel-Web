<?php

namespace App\Api\V1\Controllers\CP\Dashboard;

use Illuminate\Http\Request;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MT\Main as MT;
use App\Model\Member\Main as Member;
use App\Model\Pothole\Main as Pothole;


class Controller extends ApiController
{
    //use Helpers;

    function getData(){
       
        $mo             = MO::count(); 
        $mt             = MT::count(); 
        $member         = Member::count(); 
        $pothole        = Pothole::count(); 
        $fixed          = 0;
        $fixing          = 0;
        
        return response()->json([
            'mo'=>$mo,
            'mt'=>$mt,
            'member'=>$member,
            'pothole'=>$pothole,
            'fixed'=>$fixed,
            'fixing'=>$fixing,
        ], 200);
    }

  
   
}
