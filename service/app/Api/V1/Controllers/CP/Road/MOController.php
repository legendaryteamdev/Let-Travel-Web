<?php

namespace App\Api\V1\Controllers\CP\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MO\Road as MORoad;
use App\Model\Road\PK as RoadPK;
use App\Model\Road\Main as Road;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MOController extends ApiController
{
    use Helpers;
    function list($roadId=0){
        $data   =   MORoad::select('id', 'mo_id', 'description', 'start_pk', 'end_pk', 'created_at')->where('road_id', $roadId)
                    ->with([
                        'mo:id,name,user_id', 
                        'mo.user:id,name,phone'
                    ]); 

        $fromPK      =   intval(isset($_GET['fromPK'])?$_GET['fromPK']:0);
        $toPK        =   intval(isset($_GET['toPK'])?$_GET['toPK']:0);
        if( $fromPK != 0 && $toPK == 0 ){
            $data = $data->where('start_pk', '<=', $fromPK);
        }else  if( $fromPK == "" && $toPK != "" ){
            $data = $data->where('start_pk', '<=', $toPK)->where('end_pk', '<=', $toPK); 
        }else if( $fromPK != 0 && $toPK != 0){
            $range = [$fromPK, $toPK]; 
            $data = $data->whereBetween('start_pk', $range)->orWhereBetween('end_pk', $range); 
        }

        $mo      =   intval(isset($_GET['mo'])?$_GET['mo']:0);
        if($mo != 0){
            $data = $data->where('mo_id', $mo); 
        } 

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $data= $data->orderBy('start_pk', 'asc')->paginate($limit);

        return response()->json($data, 200);
    }

    function byMinistry(){
        $ministry      =   intval(isset($_GET['ministry'])?$_GET['ministry']:0);
        $data = MO::select('id', 'user_id')->with(['user:id,name,phone'])
                    ->whereHas('ministries', function($query) use ($ministry){
                        $query->where('ministry_id', $ministry); 
                    })
                    ->get();

        return response()->json($data, 200);
    }

    function post(Request $request, $roadId=0){
        $this->validate($request, [
            'ministry' => 'required|numeric|exists:ministry,id',
            'mo'       => 'required|numeric|exists:mo,id',
            'fromPK'   => 'required|numeric',
            'toPK'     => 'required|numeric',
        ]);

        $ministry       = intval($request->input('ministry')); 
        $mo             = intval($request->input('mo')); 
        $fromPK         = intval($request->input('fromPK')); 
        $toPK           = intval($request->input('toPK')); 

        //Check if mo belongs to Ministry
        $moData =   MO::select('id', 'user_id')->whereHas('ministries', function($query) use ($ministry){
                        $query->where('ministry_id', $ministry); 
                    })->first();
        if($moData){
            if( $fromPK <= $toPK ){

                //Check if submitted ended PK is in the range. 
                $pk      = RoadPK::select('id', 'code')->where('road_id', $roadId)->orderBy('code', 'desc')->first(); 
                if($pk){
                    if($pk->code >= $fromPK){
                        if($pk->code >= $toPK){
                            
                            //Check if this MO has redundancy pk range
                            $range = [$fromPK, $toPK]; 
                            $moRoad = MORoad::select('id', 'start_pk', 'end_pk', 'mo_id')->with(['mo:id,name'])->where('road_id', $roadId)->where(function($query) use ($range){
                                $query->whereBetween('start_pk', $range)->orWhereBetween('end_pk', $range); 
                            })->first(); 

                            if(!$moRoad){
                               
                                $data               = new MORoad;
                                $data->mo_id        = $mo; 
                                $data->road_id      = $roadId; 
                                $data->start_pk     = $request->input('fromPK');
                                $data->end_pk       = $request->input('toPK');
                                $data->updated_at   = now();
                                $data->created_at   = now(); 
                                $data->save();
                                
                                return response()->json([
                                    'status' => 'success',
                                    'message' => 'Data has been added!', 
                                    'data' => $data
                                ], 200);

                            }else{
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Sorry! Redundancy pk range is found.',
                                    'data' => $moRoad
                                ], 200);
                            }

                        }else{
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Sorry! To PK must be smaller or equal to '.$pk->code
                            ], 200);
                        } 
                    }else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Sorry! From PK must be bigger or equal to '.$pk->code
                        ], 200);
                    }  
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sorry! PK range is not aviable. 1'
                    ], 200);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'From PK must be smaller than To pK'
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'This MO does not belong to Ministry.'
            ], 200);
        }
            
           
            
    }

    function delete( $roadId = 0, $id = 0 ){
        $data = MORoad::where('road_id', $roadId)->find($id);
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

  
}
