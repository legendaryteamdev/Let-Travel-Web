<?php

namespace App\Api\V1\Controllers\CP\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\MT\Main as MT;
use App\Model\MT\Action as Main;

use App\Model\MO\Main as MO;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class ActionController extends ApiController
{
    use Helpers;
    function list($id=0){
        return response()->json(Main::select('*')->with('assigner:id,name,user_id','assigner.user:id,name,phone')->where('mt_id',$id)->orderBy('id', 'desc')->get(), 200);
    }

    function assignersList($id=0){
        return response()->json(MO::select('*')->with('user:id,name,phone')->orderBy('id', 'desc')->get(), 200);
    }

    function view($id=0){
        $data = Main::select('*')->with('assigner:id,name,user_id','assigner.user:id,name,phone')->findOrFail($id);
        if($data){
            return response()->json(['data'=>$data], 200);
        }else{
            return response()->json(['status_code'=>404], 404);
        }
    }

    function post(Request $request, $mt_id=0){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;
        $this->validate($request, [
            'assigner' => 'sometimes:required|exists:mo,id',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
       
        //================================================>> Storing for school
        $data = new Main();
        $data->mt_id = $mt_id;
        $data->assigner_id      = $request->input('assigner');
        $data->start_date       = $request->input('start_date');
        $data->end_date         = $request->input('end_date');
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបង្កើត', 
            'data' => $data, 
        ], 200);
    }

    function put(Request $request, $mt_id=0, $action_id=0){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;
        $this->validate($request, [
            'assigner' => 'sometimes:required|exists:mo,id',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        //================================================>> Storing for school
        $data = Main::findOrFail($action_id);
        $data->mt_id            = $mt_id;
        $data->assigner_id      = $request->input('assigner');
        $data->start_date       = $request->input('start_date');
        $data->end_date         = $request->input('end_date');
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'បានបង្កើតដោយជោគជ័យ', 
            'data' => $data, 
        ], 200);
    }
   
    function delete($id=0, $action_id=0){
        $data = Main::find($action_id);
        if(!$data){
            return response()->json([
                'message' => 'រកមិនឃើញទន្និន័យ', 
            ], 404);
        }
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'ការលុប បានជោគជ័យ',
        ], 200);
    }

    


}
