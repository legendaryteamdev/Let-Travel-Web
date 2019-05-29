<?php

namespace App\Api\V1\Controllers\CP\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Model\Road\Main;

class Controller extends ApiController
{
    use Helpers;
    
    function list(){
        //return $id;
        
        $data      =    Main::select('id', 'name', 'start_point', 'end_point', 'is_point_migrated', 'length', 'updated_at')
        ->with([
            'provinces:id,road_id,province_id', 
            'provinces.province:id,abbre', 
            'ministries'=>function($query){
                $query->select('ministry_id', 'road_id')->distinct()
                ->with(['ministry:id,abbre']);
            }
        ])
        ->withCount([
            'mos as n_of_mos', 
            'mts as n_of_mts', 
            'pks as n_of_pks'
        ]); 

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
       
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%');
            });
            
        }

        // $from=isset($_GET['from'])?$_GET['from']:"";
        // $to=isset($_GET['to'])?$_GET['to']:"";
        // if(isValidDate($from)){
        //     if(isValidDate($to)){
              
        //         $from .=" 00:00:00";
        //         $to .=" 23:59:59";
        //         $data = $data->whereBetween('created_at', [$from, $to]);
        //     }
        // }

        $data= $data->orderBy('name', 'asc')->orderBy('is_point_migrated', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){
        if($id!=0){
             $data      =    Main::select('id', 'name', 'start_point', 'end_point', 'is_point_migrated', 'length', 'updated_at')
            ->with([
                'provinces:id,road_id,province_id', 
                'provinces.province:id,abbre', 
                'ministries'=>function($query){
                    $query->select('ministry_id', 'road_id')->distinct()
                    ->with(['ministry:id,abbre']);
                }
            ])
            ->withCount(['mos as n_of_mos', 'mts as n_of_mts', 'parts as n_of_parts', 'pks as n_of_pks'])
            ->find($id);

            if($data){
                return response()->json(['data'=>$data], 200);
            }else{
                return response()->json(['status_code'=>404], 200);
            }
        }
    }

    // function post(Request $request){
    //     $admin_id = JWTAuth::parseToken()->authenticate()->id;

    //     $this->validate($request, [ 
    //         'start_point'   => 'required|max:160',
    //         'end_point'     => 'required|max:160',
    //     ]);

   
    //     $data = new Main();
    //     $data->start_point                      = $request->input('start_point');
    //     $data->end_point                        = $request->input('end_point');

    //     $data->save();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'ទិន្នន័យត្រូវបានបង្កើត!', 
    //         'data' => $data, 
    //     ], 200);
    // }

    function put(Request $request, $id=0){
        $this->validate($request, [
           
            'start_point'   => 'required|max:160',
            'end_point'     => 'required|max:160',
        ]);

        $data = Main::findOrFail($id);
        $data->start_point  = $request->input('start_point');
        $data->end_point    = $request->input('end_point');
        $data->updated_at   = now(); 
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
            'data' => $data
        ], 200);
    }

    // function delete($id=0){
    //     $data = Main::find($id);
    //     if(!$data){
    //         return response()->json([
    //             'message' => 'រកមិនឃើញទិន្នន័យ', 
    //         ], 404);
    //     }
    //     $data->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'ទិន្នន័យត្រូវបានលុប!',
    //     ], 200);
    // }

}
