<?php

namespace App\Api\V1\Controllers\CP\Authority\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use DB;

use App\Model\Road\Main as Road;

use App\Model\Authority\MO\Road as Main;

class RoadController extends ApiController
{
    use Helpers;
    
     function list($moId = 0){
        $data      =    Main::select('id', 'mo_id', 'road_id', 'start_pk', 'end_pk')->with(['road:id,name'])->where('mo_id', $moId)->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }

}
