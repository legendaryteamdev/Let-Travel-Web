<?php

namespace App\Api\V1\Controllers\CP\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Api\V1\Controllers\ApiController;
use App\Model\Road\Part as Part;
use App\Model\Mt\RoadPart as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class PartxController extends ApiController
{
    use Helpers;

    function gets(){
    	$key       =    isset($_GET['key'])?$_GET['key']:"";
        $data      =    Part::select('*')->with('road:id,name')->where('name', 'like', '%'.$key.'%')->limit(50)->get();
        return response()->json($data, 200);
    }

    function getExisting($mt_id = 0){
        $data = Main::select('*')->with(['roadPart:id,name,road_id','roadPart.road:id,name'])->where('mt_id', $mt_id)->get();
        return response()->json($data, 200);
    }

    function put(Request $request, $mt_id = 0){

        $this->validate($request, [
            'object' => 'required'
        ]);

        $object = json_decode($request->input('object'));

        $data = array();
        for($i = 0; $i<count($object); $i++){
            $data[] = ['mt_id'=>$mt_id, 'road_part_id'=>$object[$i], 'created_at'=>now()];
        }

        Main::insert($data);
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបន្ថែម',
            'object' => $object
        ], 200);
    }

    function delete($id = 0, $mt_road_part_id){
        $data = Main::find($mt_road_part_id);
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
