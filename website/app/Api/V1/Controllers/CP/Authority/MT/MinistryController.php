<?php

namespace App\Api\V1\Controllers\CP\Authority\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\Ministry\Main as Ministry;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MinistryController extends ApiController
{
    use Helpers;

    function list($mt_id){
    	$key       =   isset($_GET['key'])?$_GET['key']:"";
        $data      =   Ministry::select('id', 'name', 'logo', 'abbre')->withCount(['roads as n_of_roads', 'mos as n_of_mos'])
                        ->whereHas('mMos', function ($query) use ($mt_id) {
                            $query->whereHas('mMts', function ($query) use ($mt_id){
                                $query->where('mt_id', $mt_id); 
                            });
                            
                        });
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
