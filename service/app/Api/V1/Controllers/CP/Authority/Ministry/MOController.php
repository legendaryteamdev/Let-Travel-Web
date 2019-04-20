<?php

namespace App\Api\V1\Controllers\CP\Authority\Ministry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MO\Ministry as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MOController extends ApiController
{
    use Helpers;

    function gets(){
    	$key       =   isset($_GET['key'])?$_GET['key']:"";
        $data      =   MO::select('*')->whereHas('user',function($query) use($key){
            $query->where('name','like', '%'.$key.'%');
        })->with(['user:id,name,phone,email'])->limit(50)->get();
        return response()->json($data, 200);
    }

    function getExisting($ministry_id = 0){
        $data = Main::select('id','mo_id', 'created_at')->with(['mo:id,user_id','mo.user:id,name'])->where('ministry_id', $ministry_id)->get();
        return response()->json($data, 200);
    }

    function put(Request $request, $ministry_id = 0){

        $this->validate($request, [
            'object' => 'required'
        ]);

        $object = json_decode($request->input('object'));

        $data = array();
        for($i = 0; $i<count($object); $i++){
            $data[] = ['ministry_id'=>$ministry_id, 'mo_id'=>$object[$i], 'created_at'=>now()];
        }

        Main::insert($data);
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបន្ថែម',
            'object' => $object
        ], 200);
    }

    function delete($id = 0, $ministry_mo_id){
        $data = Main::find($ministry_mo_id);
        if(!$data){
            return response()->json([
                'message' => 'រកមិនឃើញទិន្នន័យ', 
            ], 404);
        }
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'បានលុបដោយជោគជ័យ',
        ], 200);
    }



}
