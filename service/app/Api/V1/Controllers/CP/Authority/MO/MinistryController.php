<?php

namespace App\Api\V1\Controllers\CP\Authority\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\Ministry\Main as Ministry;
use App\Model\Authority\MO\Ministry as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MinistryController extends ApiController
{
    use Helpers;

    function gets(){
    	$key       =   isset($_GET['key'])?$_GET['key']:"";
        $data      =   Ministry::select('*')->where('name','like', '%'.$key.'%')->limit(50)->get();
        return response()->json($data, 200);
    }

    function getExisting($mo_id = 0){
        $data = Main::select('id','ministry_id', 'created_at')->with(['ministry:id,name'])->where('mo_id', $mo_id)->get();
        return response()->json($data, 200);
    }

    function put(Request $request, $mo_id = 0){

        $this->validate($request, [
            'object' => 'required'
        ]);

        $object = json_decode($request->input('object'));

        $data = array();
        for($i = 0; $i<count($object); $i++){
            $data[] = ['mo_id'=>$mo_id, 'ministry_id'=>$object[$i], 'created_at'=>now()];
        }

        Main::insert($data);
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបន្ថែម',
            'object' => $object
        ], 200);
    }

    function delete($id = 0, $mo_ministry_id){
        $data = Main::find($mo_ministry_id);
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
