<?php

namespace App\Api\V1\Controllers\CP\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main;
use App\Model\Admin\Admin;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
   function list(){
        //return $id;
        $data = Main::select('*');
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        $appends=array('limit'=>$limit);
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%')->OrWhere('phone', 'like', '%'.$key.'%');
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

        $data= $data->where('type_id',1)->orderBy('id', 'desc')->paginate($limit);
        return response()->json($data, 200);
    }


    function view($id = 0){
        if($id!=0){
            $data = Main::select('*')->findOrFail($id);
            if($data){
                return response()->json(['data'=>$data], 200);
            }else{
                return response()->json(['status_code'=>404], 404);
            }
        }
    }

    function post(Request $request){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;

        $this->validate($request, [
            'name' => 'required|max:60',
            'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                            Rule::unique('user', 'phone')
                        ],
            'email'=>   [
                            'required', 
                            'email', 
                            'max:100', 
                            Rule::unique('user', 'email')
                        ],
            'password' => 'required|min:6|max:60',

        ]);
   		//dd($request->input('phone'));
        $user = new Main();
        $user->type_id      = 1;
        $user->name         = $request->input('name');
        $user->phone        = $request->input('phone');
        $user->email        = $request->input('email');
        $user->is_active    = 1;
        $user->password     = bcrypt($request->input('password'));
        $user->creator_id   = $admin_id;
        $user->updater_id   = $admin_id;

        $last = Main::select('id')->orderBy('id', 'DESC')->first();
        $id = 0;
        if($last){
            $id = $last->id+1;
        }
        
        if($request->input('avatar')){
            $avatar = FileUpload::forwardFile($request->input('avatar'), 'mo');
            if($avatar != ""){
                $user->avatar = $avatar; 
            }
        }
        $user->save();

        $admin              = new Admin();
        $admin->user_id      = $user->id;
        $admin->is_supper    = 0;
        $admin->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបង្កើត!', 
            'data' => $user, 
        ], 200);
    }

    function put(Request $request, $id=0){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;

        $this->validate($request, [
            'name' => 'required|max:60',
            'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                        ],
            'email'=>   [
                            'required', 
                            'email', 
                            'max:100', 
                        ]

        ]);
   
        $user = Main::findOrFail($id);
        // $user->type_id = 1;
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->telegram_chat_id = $request->input('telegram_chat_id');
        if($request->input('is_active') != null){
           $user->is_active = $request->input('is_active'); 
       }else{
        $user->is_active = 1;
       }
        
        //$user->avatar = '{}';
        $user->creator_id = $admin_id;
        $user->updater_id = $admin_id;

        if($request->input('avatar')){
            $avatar = FileUpload::forwardFile($request->input('avatar'), 'mo');
            if($avatar != ""){
                $user->avatar = $avatar; 
            }
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
            'data' => $user, 
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

    function updatePassword(Request $request, $id=0){
        $this->validate($request, [
            'password' => 'required|min:6|max:60',
        ]);


        //========================================================>>>> Start to update
        $data = Main::findOrFail($id);
        $data->password = bcrypt($request->input('password'));
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'លេខសម្ងាត់ត្រូវបានផ្លាស់ប្តូរ!', 
            'data' => $data
        ], 200);
    }


}
