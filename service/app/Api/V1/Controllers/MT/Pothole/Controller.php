<?php

namespace App\Api\V1\Controllers\MT\Pothole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Authority\MT\Main as MT;
use App\Model\Pothole\Main;
use App\Model\Pothole\Status as Status;
use App\Model\Pothole\File as File;

class Controller extends ApiController
{
    use Helpers;
    function list(){
        $user = JWTAuth::parseToken()->authenticate();
        $mt = MT::select('id')->where('user_id', $user->id)->first(); 

        $data       =   Main::select('id', 'code', 'maintence_id', 'action_id', 'point_id', 'created_at')
        ->withCount('reports as n_of_reports')
        ->with([
                'comments'=>function($query){
                    $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                    ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
                    }, 

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

                'action:id,assigner_id,mt_id,start_date,end_date', 
                'action.assigner:id,user_id', 
                'action.assigner.user:id,name', 
                'action.mt:id,user_id,province_id',
                'action.mt.user:id,name',
                'action.mt.province:id,name',

                
                'location:id,pothole_id,village_id,commune_id,district_id,province_id', 
                'location.village:id,name,code', 
                'location.commune:id,name,code', 
                'location.district:id,name,code', 
                'location.province:id,name,code', 


                'point:id,pk_id,meter', 
                'point.pk:id,code,road_id', 
                'point.pk.road:id,name,start_point,end_point',

                'statuses'=>function($query){
                    $query->select('id', 'pothole_id', 'status_id', 'updater_id', 'comment', 'updated_at')
                    ->with([
                        'status:id,name', 
                        'updater:id,name,avatar', 
                        'files:id,uri,status_id'
                    ])
                    ->orderBy('id', 'DESC')->get(); 
                }
               
            ]);
        ; 
 

        $from   =   isset($_GET['from'])?$_GET['from']:"";
        $to     =   isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){

                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $code     =   isset($_GET['code'])?$_GET['code']:"";
        if($code != ""){
            $data = $data->where('code', $code); 
        }

        $status = intval(isset($_GET['status'])?$_GET['status']:0);
        if($status != 0){
            $data = $data->whereHas('statuses', function($query) use ($status){
                $query->where('status_id', $status); 
            });
        }

        $data = $data->whereHas('action', function($query) use ($mt){
            $query->where('mt_id', $mt->id); 
        })->orderBy('id', 'desc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }

    function view($id = 0){
         $user = JWTAuth::parseToken()->authenticate();
        if($id!=0){
            $data = Main::select('id', 'code', 'maintence_id', 'action_id', 'point_id', 'created_at')
            ->with([

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

                'action:id,assigner_id,mt_id,start_date,end_date', 
                'action.assigner:id,user_id', 
                'action.assigner.user:id,name', 
                'action.mt:id,user_id,province_id',
                'action.mt.user:id,name',
                'action.mt.province:id,name',

                'point:id,pk_id,meter', 
                'point.pk:id,code,road_id', 
                'point.pk.road:id,name,start_point,end_point', 

                'location:id,pothole_id,village_id,commune_id,district_id,province_id', 
                'location.village:id,name,code', 
                'location.commune:id,name,code', 
                'location.district:id,name,code', 
                'location.province:id,name,code', 

            ])->findOrFail($id);

            $statuses = Status::select('*')->with([
                'status:id,name', 
                'updater:id,name,avatar', 
                'files:id,uri,status_id,lat,lng'
            ])->where('pothole_id', $id)->orderBy('id', 'desc')->get();

            if($data){
                return response()->json(['data'=>$data,'statuses'=>$statuses], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

    function put(Request $request, $id=0){
        $this->validate($request, [
            'name'          => 'required|max:160',
            'start_point'   => 'required|max:160',
            'end_point'     => 'required|max:160',
        ]);


        //========================================================>>>> Start to update
        $data = Main::findOrFail($id);
        $data->name                             = $request->input('name');
        $data->start_point                      = $request->input('start_point');
        $data->end_point                        = $request->input('end_point');
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
            'data' => $data
        ], 200);
    }

    function delete($id=0){
        $data = Main::find($id);
        if(!$data){
            return response()->json([
                'message' => 'រកមិនឃើញទិន្នន័យ', 
            ], 404);
        }
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានលុប!',
        ], 200);
    }

    function files($potholeId = 0){
        $data = File::select('id', 'uri', 'lat', 'lng', 'report_id')->whereHas('report', function($query) use ($potholeId){
            $query->where('pothole_id', $potholeId); 
        })->get(); 
        return response()->json($data, 200);
    }

}
