<?php

namespace App\Api\V1\Controllers\CP\Reporter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User;
use App\Model\Member\Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){
        //return $id;
        $data = Main::select('id','created_at','user_id')->with(['user:id,name,phone,email,avatar,is_phone_verified,is_email_verified'])->withCount(['reports as n_of_reports']);
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        $appends=array('limit'=>$limit);
        if( $key != "" ){
            $data = $data->whereHas('user', function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%')->orWhere('phone', 'like', '%'.$key.'%')->orWhere('email', 'like', '%'.$key.'%');
            });
            $appends['key'] = $key;
               
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

        $data= $data->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }

    function view($id = 0){
         if($id!=0){
            $data = Main::select('*')->with(['user'])->findOrFail($id);
            if($data){
                return response()->json(['data'=>$data], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

   
    function delete($id=0){
        $data = Main::find($id);
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
