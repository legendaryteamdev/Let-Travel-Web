<?php

namespace App\Api\V1\Controllers\CP\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Dingo\Api\Routing\Helpers;

use App\Api\V1\Controllers\ApiController;
use App\Model\Road\Main as Road;
use App\Model\Road\PK as RoadPK;
use App\Model\Authority\Ministry\Main as Ministry;
use App\Model\Authority\Ministry\Road as MinistryRoad;
use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MO\Road as MORoad;
use App\Model\Authority\MT\Main as MT;
use App\Model\Authority\MT\Road as MTRoad;

class MTController extends ApiController
{
    use Helpers;
    function list($roadId=0){
        $data   =   MTRoad::select('id', 'mt_id', 'description', 'start_pk', 'end_pk', 'created_at')->where('road_id', $roadId)
                    ->with([
                        'mt:id,name,user_id,province_id', 
                        'mt.user:id,name,phone', 
                        'mt.province:id,name'
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

        $mt      =   intval(isset($_GET['mt'])?$_GET['mt']:0);
        if($mt != 0){
            $data = $data->where('mt_id', $mt); 
        } 

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $data= $data->orderBy('start_pk', 'asc')->paginate($limit);

        return response()->json($data, 200);
    }

    function myMO(){
        $mo     =   intval(isset($_GET['mo'])?$_GET['mo']:0);
        $data   =   MT::select('id', 'user_id')->with(['user:id,name,phone'])
                    ->whereHas('mos', function($query) use ($mo){
                        $query->where('mo_id', $mo); 
                    })
                    ->get();

        return response()->json($data, 200);
    }

    function post(Request $request, $roadId=0){
        $this->validate($request, [
            'ministry' => 'required|numeric|exists:ministry,id',
            'mo'       => 'required|numeric|exists:mo,id',
            'mt'       => 'required|numeric|exists:mt,id',
            'fromPK'   => 'required|numeric',
            'toPK'     => 'required|numeric',
        ]);

        $ministry       = intval($request->input('ministry')); 
        $mo             = intval($request->input('mo')); 
        $mt             = intval($request->input('mt')); 
        $fromPK         = intval($request->input('fromPK')); 
        $toPK           = intval($request->input('toPK')); 

        //Check if mo belongs to Ministry
        $moData =   MO::select('id', 'user_id')->whereHas('ministries', function($query) use ($ministry){
                        $query->where('ministry_id', $ministry); 
                    })->first();

        if($moData){
            //Check if MT belongs to MO
            $mtData =   MT::select('id', 'user_id')->whereHas('mos', function($query) use ($mo){
                        $query->where('mo_id', $mo); 
                    })->first();

            if($mtData){
                if( $fromPK <= $toPK ){

                    //Check if submitted ended PK is in the range. 
                    $pk      = RoadPK::select('id', 'code')->where('road_id', $roadId)->orderBy('code', 'desc')->first(); 
                    if($pk){
                        if($pk->code >= $fromPK){
                            if($pk->code >= $toPK){
                                
                                //Check if this MO has redundancy pk range
                                $range = [$fromPK, $toPK]; 
                                $mtRoad = MTRoad::select('id', 'start_pk', 'end_pk', 'mt_id')->with(['mt:id,name'])->where('road_id', $roadId)->where(function($query) use ($range){
                                    $query->whereBetween('start_pk', $range)->orWhereBetween('end_pk', $range); 
                                })->first(); 

                                if(!$mtRoad){
                                   
                                    $data               = new MTRoad;
                                    $data->mt_id        = $mo; 
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
                                        'data' => $mtRoad
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
                    'message' => 'This MT does not belong to MO.'
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
        $data = MTRoad::where('road_id', $roadId)->find($id);
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
