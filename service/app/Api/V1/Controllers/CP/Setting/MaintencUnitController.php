<?php

namespace App\Api\V1\Controllers\CP\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\Model\Setting\Maintence\Unit as Model;

use Dingo\Api\Routing\Helpers;

class MaintencUnitController extends ApiController
{
    use Helpers;
    function list(){
        

        $data = Model::select('*')->withCount('codes as n_of_codes');
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('kh_name', 'like', '%'.$key.'%')->orWhere('en_name', 'like', '%'.$key.'%');
            });
        }
        
        $from=isset($_GET['from'])?$_GET['from']:"";
        $to=isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){

                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $data= $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){
        if($id!=0){
            $data = Model::find($id);
            if(count($data) == 1){
                return response()->json(['data'=>$data], 200);
            }
        }else{
            return response()->json([], 404);
        }
    }

    function post(Request $request){
        $this->validate($request, [
            'kh_name' => 'required|max:60', 
            'en_name' => 'required|max:60'
        ]);


        $data = new Model;
        
        $data->kh_name = $request->input('kh_name');
        $data->en_name = $request->input('en_name');
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបង្កើត!', 
            'data' => $data
        ], 200);

    }

    function put(Request $request, $id=0){
        $this->validate($request, [
            'kh_name' => 'required|max:60', 
            'en_name' => 'required|max:60'
        ]);


        $data = Model::find($id);
        if(!$data){
            return response()->json([
                'message' => 'រកមិនឃើញទិន្នន័យ', 
            ], 404);
        }

        $data->kh_name = $request->input('kh_name');
        $data->en_name = $request->input('en_name');
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
            'data' => $data
        ], 200);

    }

    function delete($id=0){
        $data = Model::find($id);
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
