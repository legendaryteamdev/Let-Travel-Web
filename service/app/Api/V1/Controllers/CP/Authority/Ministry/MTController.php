<?php

namespace App\Api\V1\Controllers\CP\Authority\Ministry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MT\Main as MT;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MTController extends ApiController
{
    use Helpers;

    function list($ministry_id){
    	$key       =   isset($_GET['key'])?$_GET['key']:"";
        $data      =   MT::select('id', 'user_id', 'name')->with('user:id,name,phone,email')
                        ->whereHas('mMos', function ($query) use ($ministry_id) {
                            $query->whereHas('mMinistries', function ($query) use ($ministry_id){
                                $query->where('ministry_id', $ministry_id); 
                            });
                            
                        })
                        ->withCount('mMos as n_of_mos')
                        ->withCount('mRoads as n_of_m_roads');
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
        
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%');
            });
            
        }

        $data= $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

}
