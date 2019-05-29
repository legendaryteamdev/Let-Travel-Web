<?php

namespace App\Api\V1\Controllers\Client\Pothole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Pothole\Main as Pothole;

class Controller extends ApiController
{
    use Helpers;
    function list(){
       

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
                                    $query->select('id', 'pothole_id', 'status_id', 'updater_id', 'comment', 'updated_at')
                                    ->with([
                                        'status:id,name', 
                                        'updater:id,name,avatar', 
                                        'files:id,uri,status_id'
                                    ])
                                    ->orderBy('id', 'DESC')->get(); 
                                }
                               
                            ]);


        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $appends=array('limit'=>$limit);
       
        $from=isset($_GET['from'])?$_GET['from']:"";
        $to=isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){
                $appends['from'] = $from;
                $appends['to'] = $to;
                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $data= $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){

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
                                    $query->select('id', 'pothole_id', 'status_id', 'updater_id', 'comment', 'updated_at')
                                    ->with([
                                        'status:id,name', 
                                        'updater:id,name,avatar', 
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

    function edit(Request $request, $id = 0){
        $userId = JWTAuth::parseToken()->authenticate()->id;

        $this->validate($request, [ 
            'description'          => 'required|max:255'
        ], 
            [
                'description.required' => 'សូមបញ្ចូលការពិពណ៌នា', 
                'description.max' => 'អត្ថបទអតិបរមាគឺ 255 តួអក្សរ', 
            ]
        );

   
        $data = Pothole::find($id);
        if($data){

            $data->name                             = $request->input('name');
            $data->start_point                      = $request->input('start_point');
            $data->end_point                        = $request->input('end_point');
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'ទិន្នន័យត្រូវបានបង្កើត!', 
                'data' => $data, 
            ], 200);
        }else{
            return response()->json(['status'=>'error', 'message'=>'No Data Found'], 404);
        }
            
    }



}
