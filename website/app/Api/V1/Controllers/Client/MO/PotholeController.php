<?php

namespace App\Api\V1\Controllers\Client\MO;

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
        //Fetch authenticated user information
        $user = JWTAuth::parseToken()->authenticate();

        $data = Pothole::select('id', 'code', 'action_id', 'point_id', 'maintence_id', 'created_at', 'updated_at')
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

                        'maintence'=>function($query) use ($user){
                            $lang = $user->lang; 
                            $query->select('id', 'group_id', 'type_id', 'subtype_id', 'unit_id', 'code', $lang.'_name as name', 'rate')
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
                            ]);
                        },

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
                       
                    ]);

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

    function view($id = 0){
        //Fetch authenticated user information
        $user = JWTAuth::parseToken()->authenticate();

        $data = Pothole::select('id', 'code', 'action_id', 'point_id', 'maintence_id', 'created_at', 'updated_at')
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

                                'maintence'=>function($query) use ($user){
                                    $lang = $user->lang; 
                                    $query->select('id', 'group_id', 'type_id', 'subtype_id', 'unit_id', 'code', $lang.'_name as name', 'rate')
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
                                    ]);
                                },

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
                               
                            ])->find($id);
        if($data){
            return response()->json($data, 200);
        }else{
            return response()->json(['status'=>'error', 'message'=>'No Data Found'], 404);
        }
    }


    function mts($potholeId){
        $potholeData = Pothole::select('id', 'point_id')
                    ->with([
                        'point:id,pk_id,meter', 
                        'point.pk:id,code,road_id', 

                        'location:id,pothole_id,village_id,commune_id,district_id,province_id', 
                        'location.village:id,name,code', 
                        'location.commune:id,name,code', 
                        'location.district:id,name,code', 
                        'location.province:id,name,code', 
                       
                    ])->find($potholeId);

        if($potholeData){
            if($potholeData->point){
                
              
                $mts = MT::select('id', 'user_id', 'province_id', 'name')
                ->with(['user:id,name,avatar,phone,email', 'province:id,name,abbre'])

                ->whereHas('roads', function($query) use ($potholeData){
                    $query->where('road_id', $potholeData->point->pk->road_id)
                    ->where('start_pk', '<=', $potholeData->point->pk->code)
                    ->where('end_pk', '>=', $potholeData->point->pk->code)
                    ;
                })
                
                ->orderBy('id', 'desc')->get();

                return response()->json(['mts'=>$mts, 'potholeData'=>$potholeData, 'status_code'=>200], 200);

            }elseif($potholeData->location){

                $mts = MT::select('id', 'user_id', 'province_id', 'name')
                ->with(['user:id,name,avatar,phone,email', 'province:id,name,abbre'])
                ->where('province_id', $potholeData->location->province_id)->orWhere('id', '>=', 26)->orderBy('id', 'desc')->get();
                return response()->json(['mts'=>$mts, 'potholeData'=>$potholeData, 'status_code'=>200], 200);

            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['Pothole does not have point.']]
                ], 403);
            }
        }else{
            
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['Invalid pothole']]
            ], 403);
        }
    }


    function assign(Request $request, $potholeId = 0){
        
        $this->validate($request, [ 
            'mt_id'                 => 'required|exists:mt,id'
        ], 
            [
                'mt_id.required' => 'Please choose an MT', 
                'mt_id.exists' => 'Invalid mt' 
            ]
        );

        $user = JWTAuth::parseToken()->authenticate(); 
        $mt = MT::select('id', 'user_id')->with(['user:id,app_token,name,avatar,phone,email'])
        ->whereHas('mos', function($query) use ($user){
            $query->whereHas('mo', function($query) use ($user){
                $query->where('user_id', $user->id); 
            });
        })
        ->find($request->input('mt_id')); 

        //return $mt;
        
        if($mt){
            $pothole = Pothole::find($potholeId);
            if($pothole){
                //if(is_null($pothole->action_id)){

                    //Create an action
                    $action = new Action; 
                    $action->assigner_id = $user->mo->id; 
                    $action->mt_id      = $request->input('mt_id');
                    $action->start_date = date('Y-m-d'); 
                    $action->save(); 

                    //Update pothole
                    $pothole->action_id = $action->id; 
                    $pothole->maintence_id = $request->input('maintence_code_id');
                    $pothole->save();

                    //Update pothole Status
                    $status             = new PotholeStatus; 
                    $status->pothole_id = $pothole->id; 
                    $status->status_id  = 2; //Repairing
                    $status->mt_id      = $request->input('mt_id');
                    $status->comment    = $request->input('comment');
                    $status->creator_id = $user->id; 
                    $status->updater_id = $user->id; 
                    $status->save();


                    //Send notification to MT
                    if($mt){
                        //Find image
                        $file = File::select('id', 'uri', 'report_id')->whereHas('report', function($query) use ($potholeId){
                            $query->where('pothole_id', $potholeId); 
                        })->first();
                        $image = ''; 
                        if($file){
                            $image = $file->uri; 
                        }

                        $metaData = [
                            'way'           =>  'firebase', 
                            'title'         =>  'New Work!', 
                            'description'   =>  'New pothole has been assigned to you.', 
                            'type'          =>  'Repairing', 
                            'image'         =>   $image, 
                            'action'       =>   'potholedetail', 
                            'action_id'     =>    $pothole->id
                        ];

                        Notify::send($mt->user_id, $metaData);

                        
                    }

                    //Send notification to RU
                    $sentList = []; 
                    $reporters = Report::select('member_id', 'id')->distinct()->with(['ru:id,user_id', 'ru.user:id,app_token'])->where('pothole_id', $potholeId)->get(); 
                    foreach($reporters as $reporter){
                        
                        if(!in_array($reporter->id, $sentList)){
                            $file = File::select('id', 'uri', 'report_id')->where('report_id', $reporter->id)->first();
                            $image = ''; 

                            if($file){
                                $image = $file->uri; 
                            }

                            $metaData = [
                                'way'           =>  'firebase', 
                                'title'         =>  'Report Accetped', 
                                'description'   =>  'MT has taken action.', 
                                'type'          =>  'Repairing', 
                                'image'         =>   $image, 
                                'action'       =>   'feeddetail', 
                                'action_id'     =>    $reporter->id
                            ];

                            Notify::send($reporter->ru->user->id, $metaData);
                            $sentList[] = $reporter->id; 
                        }
                            
                        
                    }

                    return response()->json([
                        'message' => 'Pothole has been assigned to MT',
                        'status_code' => 200, 
                        'mt'=>$mt
                    ], 200);
                    
                // }else{
                //     return response()->json(['status'=>'error', 'message'=>'Pothole has already been assigned'], 403);
                // }
            }else{
                return response()->json(['status'=>'error', 'message'=>'invalid pothole'], 403);
            }
        }else{
            return response()->json(['status'=>'error', 'message'=>'invalid mt'], 403);
        }
      
    }



}
