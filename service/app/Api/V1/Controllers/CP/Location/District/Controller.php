<?php

namespace App\Api\V1\Controllers\CP\Location\District;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Location\District as Main;
use App\Model\Location\Province;

use App\Model\User\Main as User;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){
        //==================================== Get Commune
        $provinces = Province::get();
        //==================================== Get Data

        $data       = Main::select('*')
        ->withCount([
                'communes as n_of_communes',
                'villages as n_of_villages'
                ])
        ->with('province:id,name,en_name');
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where('name', 'like', '%'.$key.'%')->orWhere('code', 'like', '%'.$key.'%');
        }

        $province       =   isset($_GET['province'])?$_GET['province']:0;
        if( $province != 0 ){
            $data = $data->where('province_id', $province);
        }

        $from = isset($_GET['from'])?$_GET['from']:"";
        $to   = isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){
                $appends['from'] = $from;
                $appends['to'] = $to;
                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $data= $data->orderBy('province_id', 'asc')->paginate($limit);
        return response()->json(['data'=>$data, 'provinces'=>$provinces], 200);
    }


    function view($id = 0){
        if($id!=0){
            $data = Main::select('*')->with('province:id,name,en_name')->findOrFail($id);
            if($data){
                //==================================== Get Commune
                $provinces = Province::get();
                //==================================== Get Data
                return response()->json(['data'=>$data,'provinces'=>$provinces], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

    // function post(Request $request){
    //     $admin_id = JWTAuth::parseToken()->authenticate()->id;

    //     $this->validate($request, [
    //         'code'      => 'required|max:160',
    //         'name'      => 'required|max:160',

    //     ]);

    //     $data                   = new Main();
    //     $data->code             = $request->input('code');
    //     $data->name             = $request->input('name');
    //     $data->boundary         = $request->input('boundary');
    //     $data->central          = $request->input('central');
    //     $data->lat              = $request->input('lat');
    //     $data->lng              = $request->input('lng');
    //     $data->created_at       = now();
    //     $data->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'ទិន្នន័យត្រូវបានបង្កើត', 
    //         'data' => $data, 
    //     ], 200);
    // }

    function put(Request $request, $id=0){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;
        $this->validate($request, [
            'code'      => 'required|max:160',
            'name'      => 'required|max:160',

        ]);

        $data                   = Main::findOrFail($id);
        //$data->province_id      = $request->input('province');
        $data->code             = $request->input('code');
        $data->name             = $request->input('name');
        // $data->boundary         = $request->input('boundary');
        // $data->central          = $request->input('central');
        $data->lat              = $request->input('lat');
        $data->lng              = $request->input('lng');
        $data->created_at       = now();
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

    


}
