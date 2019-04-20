<?php

namespace App\Api\V1\Controllers\Client\Nearby;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;

use App\MPWT\LatLngUMTConvert;
use App\MPWT\RoadCare; 




class NearbyController extends ApiController
{
    use Helpers;

    function locations(Request $request){
        
        //Check validation 
        $this->validate($request, [  
            'lat'               => 'required|numeric', 
            'lng'               => 'required|numeric'
        ]);

        $lat = $request->get('lat'); 
        $lng = $request->get('lng'); 

        $data = RoadCare::getLocation($lat, $lng);
       
        return response()->json($data, 200);
    }


    
    function nrs(Request $request){
        
        //Check validation 
        $this->validate($request, [  
            'lat'               => 'required|numeric', 
            'lng'               => 'required|numeric'
        ]);

        $data = RoadCare::getRoad($request->get('lat'), $request->get('lng')); 
        return response()->json(['data'=>$data, 'status_code'=>200], 200);
    }

    function potholes(Request $request){
        
        //Check validation 
        $this->validate($request, [  
            'lat'               => 'required|numeric', 
            'lng'               => 'required|numeric',
        ]);

        $data = RoadCare::potholeSearching($request->get('lat'), $request->get('lng')); 
        return response()->json(['data'=>$data, 'status_code'=>200], 200);
    }
}
