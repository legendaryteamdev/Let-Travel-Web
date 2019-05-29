<?php

namespace App\Api\V1\Controllers\CP\Authority\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use DB;

use App\Model\Road\Main as Road;

use App\Model\Authority\MT\Road as Main;

class RoadController extends ApiController
{
    use Helpers;
    function list($mtId=0){
    	$data      =    Main::select('id', 'mt_id', 'road_id', 'start_pk', 'end_pk')->with(['road:id,name'])->where('mt_id', $mtId)->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }


}
