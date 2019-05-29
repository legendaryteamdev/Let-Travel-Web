<?php

namespace App\Api\V1\Controllers\CP\Authority\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MT\Main as MT;
use App\Model\Authority\MT\MO as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class MTController extends ApiController
{
    use Helpers;

    function gets(){
    	$key       =   isset($_GET['key'])?$_GET['key']:"";
        $data      =   MT::select('id', 'user_id', 'description', 'name')->with(['user:id,name,phone,email'])->whereHas('user',function($query) use($key){
            $query->where('name','like', '%'.$key.'%');
        })->limit(50)->get();
        return response()->json($data, 200);
    }

    function getExisting($mo_id = 0){
        $data = Main::select('id','mt_id', 'created_at')->with(['mt:id,user_id','mt.user:id,name'])->where('mo_id', $mo_id)->get();
        return response()->json($data, 200);
    }

    function put(Request $request, $mo_id = 0){

        $this->validate($request, [
            'object' => 'required'
        ]);

        $object = json_decode($request->input('object'));

        $data = array();
        for($i = 0; $i<count($object); $i++){
            $data[] = ['mo_id'=>$mo_id, 'mt_id'=>$object[$i], 'created_at'=>now()];
        }

        Main::insert($data);
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបន្ថែម',
            'object' => $object
        ], 200);
    }

    function delete($id = 0, $mo_mt_id){
        $data = Main::find($mo_mt_id);
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
