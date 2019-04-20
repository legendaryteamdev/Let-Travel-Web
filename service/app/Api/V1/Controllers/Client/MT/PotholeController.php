<?php

namespace App\Api\V1\Controllers\Client\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\MPWT\Notification as Notify;
use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Report as Report;
use App\Model\Pothole\Status as PotholeStatus;
use App\Model\Pothole\File as File;
use App\Model\Authority\MT\Main as MT;
use App\Model\Authority\MT\Action as Action;



class PotholeController extends ApiController
{
    use Helpers;
    function list(){
        $user = JWTAuth::parseToken()->authenticate();
        $data = Pothole::select('id', 'action_id', 'point_id', 'created_at', 'updated_at')
                ->withCount('reports as n_of_reports')
                ->with([
                        'comments'=>function($query){
                            $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                            ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
                            }, 

                        'location:id,pothole_id,village_id,commune_id,district_id,province_id', 
                        'location.village:id,name,code', 
                        'location.commune:id,name,code', 
                        'location.district:id,name,code', 
                        'location.province:id,name,code', 

                        'point:id,pk_id,meter', 
                        'point.pk:id,code,road_id', 
                        'point.pk.road:id,name,start_point,end_point',

                        'statuses'=>function($query){
                            $query->select('id', 'pothole_id', 'status_id', 'mt_id', 'updater_id', 'comment', 'updated_at')
                            ->with([
                                'status:id,name', 
                                'updater:id,name,avatar', 
                                'mt:id,user_id', 
                                'mt.user:id,name,avatar', 
                                'files:id,uri,status_id'
                            ])
                            ->orderBy('id', 'DESC')->get(); 
                        }
                       
                    ])
                    ->whereHas('action', function($query) use ($user){
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
        $data       =   $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){
        $user = JWTAuth::parseToken()->authenticate();
         $data = Pothole::select('id', 'action_id', 'point_id', 'created_at', 'updated_at')
                ->withCount('reports as n_of_reports')
                ->with([
                        'comments'=>function($query){
                            $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                            ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
                            }, 

                        'location:id,pothole_id,village_id,commune_id,district_id,province_id', 
                        'location.village:id,name,code', 
                        'location.commune:id,name,code', 
                        'location.district:id,name,code', 
                        'location.province:id,name,code', 

                        'point:id,pk_id,meter', 
                        'point.pk:id,code,road_id', 
                        'point.pk.road:id,name,start_point,end_point',

                          'statuses'=>function($query){
                            $query->select('id', 'pothole_id', 'status_id', 'mt_id', 'updater_id', 'comment', 'updated_at')
                            ->with([
                                'status:id,name', 
                                'updater:id,name,avatar', 
                                'mt:id,user_id', 
                                'mt.user:id,name,avatar', 
                                'files:id,uri,status_id'
                            ])
                            ->orderBy('id', 'DESC')->get(); 
                        }
                       
                    ])
                    ->whereHas('action', function($query) use ($user){
                        $query->whereHas('mt', function($query) use ($user){
                            $query->where('user_id', $user->id);
                        }); 
                    })
                    ->find($id);
        if($data){
            return response()->json($data, 200);
        }else{
            return response()->json(['status'=>'error', 'message'=>'No Data Found'], 404);
        }
    }


}
