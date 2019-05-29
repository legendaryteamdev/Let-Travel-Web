<?php

namespace App\Api\V1\Controllers\CP\Location\Village;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use App\MPWT\LatLngUMTConvert; 
use App\Api\V1\Controllers\ApiController;
use App\Model\Location\Village as Main;
use App\Model\Location\Commune;

use App\Model\User\Main as User;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){

        
        //==================================== Get Data
        $data = Main::select('id', 'name', 'code', 'commune_id', 'lat', 'lng', 'updated_at')
        ->with([
            'commune:id,name,district_id',
            'commune.district:id,name,province_id',
            'commune.district.province:id,name,en_name'
        ]);
        
        
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where('name', 'like', '%'.$key.'%')->orWhere('code', 'like', '%'.$key.'%');
        }

        $lat       =   isset($_GET['lat'])?$_GET['lat']:"";
        $lng       =   isset($_GET['lng'])?$_GET['lng']:"";
        $r         =   intval(isset($_GET['r'])?$_GET['r']:1000);

        if($lat != "" && $lng != ""){
            $utm = LatLngUMTConvert::ll2utm($lat, $lng); 

            $data = $data->selectRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance")
            ->whereRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)
            ->orderBy('distance', 'ASC'); 
        }

        $commune       =   isset($_GET['commune'])?$_GET['commune']:0;
        if( $commune != 0 ){
            $data = $data->where('commune_id', $commune);
        }

        $data= $data->orderBy('name', 'asc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }


    function view($id = 0){
        if($id!=0){
            $data = Main::select('id','name','code','commune_id','code','lat','lng')->with('commune:id,name,district_id','commune.district:id,name,province_id','commune.district.province:id,name,en_name')->findOrFail($id);
            if($data){
                
                return response()->json(['data'=>$data], 200);
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
    //         'en_name'   => 'required|max:160',
    //         'abbre'     => 'required|max:160',

    //     ]);

    //     $data                   = new Main();
    //     $data->code             = $request->input('code');
    //     $data->name             = $request->input('name');
    //     $data->en_name          = $request->input('en_name');
    //     $data->abbre            = $request->input('abbre');
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
        //$data->commune_id       = $request->input('commune');
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
