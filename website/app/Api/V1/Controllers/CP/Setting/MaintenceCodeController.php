<?php

namespace App\Api\V1\Controllers\CP\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\Model\Setting\Maintence\Main as Model;

use Dingo\Api\Routing\Helpers;

class MaintenceCodeController extends ApiController
{
    use Helpers;
    function list(){
        

        $data = Model::select('*')->with(['group:id,en_name,kh_name', 'type:id,en_name,kh_name', 'subtype:id,en_name,kh_name', 'unit:id,en_name,kh_name'])
        ->withCount(['potholes as n_of_potholes']);
         
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
        $data= $data->orderBy('code', 'asc')->paginate($limit);
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
            'code' => 'required|max:160', 
            'rate' => 'required|numeric', 

            'kh_name' => 'required|max:160', 
            'en_name' => 'required|max:160', 

            'group'      => 'required|exists:maintences_group,id',
            'type'       => 'required|exists:maintences_type,id',
            'subtype'    => 'required|exists:maintences_subtype,id',
            'unit'       => 'required|exists:maintences_unit,id',
        ]);


        $data = new Model;
        
        $data->code      = $request->input('code');
        $data->rate      = $request->input('rate');

        $data->kh_name      = $request->input('kh_name');
        $data->en_name      = $request->input('en_name');

        $data->group_id     = $request->input('group');
        $data->type_id      = $request->input('type');
        $data->subtype_id   = $request->input('subtype');
        $data->unit_id      = $request->input('unit');

        $data->description      = $request->input('description');

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
            'code' => 'required|max:160', 
            'rate' => 'required|numeric', 

            'kh_name' => 'required|max:160', 
            'en_name' => 'required|max:160', 

            'group'      => 'required|exists:maintences_group,id',
            'type'       => 'required|exists:maintences_type,id',
            'subtype'    => 'required|exists:maintences_subtype,id',
            'unit'       => 'required|exists:maintences_unit,id',
        ]);


        $data = Model::find($id);
        if(!$data){
            return response()->json([
                'message' => 'រកមិនឃើញទិន្នន័យ', 
            ], 404);
        }

        $data->code      = $request->input('code');
        $data->rate      = $request->input('rate');

        $data->kh_name      = $request->input('kh_name');
        $data->en_name      = $request->input('en_name');

        $data->group_id     = $request->input('group');
        $data->type_id      = $request->input('type');
        $data->subtype_id   = $request->input('subtype');
        $data->unit_id      = $request->input('unit');

        $data->description      = $request->input('description');

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
