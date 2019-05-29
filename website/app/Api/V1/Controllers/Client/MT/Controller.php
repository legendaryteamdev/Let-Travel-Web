<?php

namespace App\Api\V1\Controllers\Client\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Pothole\Main as Pothole;
use App\Model\Authority\MO\Main as MO;
use App\Model\Setting\Maintence\Main as Maintence;

class Controller extends ApiController
{
    use Helpers;
   
    function mos(){
        $user = JWTAuth::parseToken()->authenticate(); 

        $data = MO::select('id', 'user_id', 'name')
        ->with(['user:id,name,avatar,phone,email'])
        ->whereHas('mts', function($query) use ($user){
            $query->whereHas('mt', function($query) use ($user){
                $query->where('user_id', $user->id); 
            });
        })
        ;

       
        $from=isset($_GET['from'])?$_GET['from']:"";
        $to=isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){

                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $data= $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function maintenceCodes(Request $request){

        $lang = JWTAuth::parseToken()->authenticate()->lang;
        if($request->get('lang')){
            if($request->get('lang') == 'en' || $request->get('lang') == 'kh'){
                $lang = $request->get('lang'); 
            }
        }

        $maintenceCodes = Maintence::select('id', 'group_id', 'type_id', 'subtype_id', 'unit_id', 'code', $lang.'_name as name', 'rate', 'description')
        ->with([
            'group'=>function($query) use ($lang){
                $query->select('id', $lang.'_name as name');
            },
            'type'=>function($query) use ($lang){
                $query->select('id', $lang.'_name as name');
            },
            'subtype'=>function($query) use ($lang){
                $query->select('id', $lang.'_name as name');
            },
            'unit'=>function($query) use ($lang){
                $query->select('id', $lang.'_name as name');
            },
        ])->get(); 

        return response()->json(['data'=>$maintenceCodes, 'status_code'=>200], 200);
    }


}
