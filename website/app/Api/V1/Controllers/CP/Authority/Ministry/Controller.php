<?php

namespace App\Api\V1\Controllers\CP\Authority\Ministry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\Ministry\Main;

use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){

        $data       =   Main::select('id', 'name', 'logo', 'abbre')->withCount(['roads as n_of_roads', 'mos as n_of_mos']);
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
        
        if( $key != "" ){
           $query->where('name', 'like', '%'.$key.'%');
        }

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

        $data= $data->orderBy('id', 'asc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){

        if($id!=0){
            $data = Main::select('*')->withCount(['roads as n_of_roads', 'mos as n_of_mos'])->find($id);
            if($data){
                return response()->json(['data'=>$data], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

    function post(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [
            'name' => 'required|max:50',
            'abbre' => 'required|max:50'

        ]);

        $data               = new Main();
        $data->name         = $request->input('name');
        $data->abbre        = $request->input('abbre');
        $data->description  = $request->input('description');

        if($request->input('logo')){
            $logo = FileUpload::forwardFile($request->input('logo'), 'ministry');
            if($logo != ""){
                $data->logo = $logo; 
            }
        }

        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been created.', 
            'data' => $data, 
        ], 201);
    }

    function put(Request $request, $id=0){
       
        $this->validate($request, [
            'name' => 'required|max:50',
            'abbre' => 'required|max:50'

        ]);

        $data               = Main::find($id);
        if( $data){
            $data->name         = $request->input('name');
            $data->abbre        = $request->input('abbre');
            $data->description  = $request->input('description');
            $data->updated_at   = now(); 


            if($request->input('logo')){
                $logo = FileUpload::forwardFile($request->input('logo'), 'ministry');
                if($logo != ""){
                    $data->logo = $logo; 
                }
            }
             
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
                'data' => $data
            ], 200);
        }else{
            return response()->json(['status_code'=>404], 404);
        }

            
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

}
