<?php

namespace App\Api\V1\Controllers\MO\Dashboard;

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
        $mo = MO::select('id')->with(['mts:id,mt_id,mo_id', 'mts.mt:id,province_id'])->where('user_id', $user->id)->first(); 
        $provinces = []; 
        foreach($mo->mts as $row){
            if($row->mt->province_id != null){
                $provinces[] = $row->mt->province_id; 
            } 
        }

        $pothole        = Pothole::whereHas('location', function($query) use ($provinces){
          $query->whereIn('province_id', $provinces);
        }); 

        $total = $pothole->count(); 
       
        
        return response()->json([
         
            'total'         => $total
        ], 200);
    }

  
   
}
