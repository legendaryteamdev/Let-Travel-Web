<?php

namespace App\Api\V1\Controllers\CP\Authority\MO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Authority\MO\Main;

use App\Model\User\Main as User;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class Controller extends ApiController
{
    use Helpers;
    function list(){
       

        $data       =   Main::select('id', 'user_id', 'description', 'name')->with(['user:id,name,phone,email,avatar'])->withCount('mMinistries as n_of_m_ministries')->withCount('mMts as n_of_mts')->withCount('mRoads as n_of_m_roads');
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key        =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->whereHas('user', function($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%')->orWhere('phone', 'like', '%'.$key.'%')->orWhere('email', 'like', '%'.$key.'%');
            });
        }

        $ministry       =   isset($_GET['ministry'])?$_GET['ministry']:0;
        if( $ministry != 0 ){
            $data = $data->where('ministry_id', $ministry);
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
            $data = Main::select('id', 'user_id', 'description', 'name')->with(['user:id,name,phone,email,avatar'])->withCount('mMinistries as n_of_m_ministries')->withCount('mMts as n_of_mts')->withCount('mRoads as n_of_m_roads')->findOrFail($id);
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

        $user = new User();
        $user->type_id      = 2;
        $user->name         = $request->input('name');
        $user->phone        = $request->input('phone');
        $user->is_phone_verified        = 1;
        $user->email        = $request->input('email');
        $user->is_email_verified        = 1;
        $user->is_active    = 1;
        $user->password     = bcrypt($request->input('password'));
        $user->creator_id   = $admin_id;
        $user->updater_id   = $admin_id;
        $user->created_at     = now();

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

        $mo                 = new Main();
        $mo->user_id        = $user->id;
        $mo->name           = $request->input('mo_name');
        $mo->description    = $request->input('description');
        $mo->creator_id     = $admin_id;
        $mo->updater_id     = $admin_id;
        $mo->created_at     = now();
        $mo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ទិន្នន័យត្រូវបានបង្កើត', 
            'data' => $mo, 
        ], 200);
    }

    function put(Request $request, $id=0){
        $admin_id = JWTAuth::parseToken()->authenticate()->id;
        $user_id = $request->input('user_id');
        //========================================================>>>> Start to update
        $user = User::findOrFail($user_id);
        $user->type_id      = 2;
        $user->name         = $request->input('name');
        $user->phone        = $request->input('phone');
        $user->email        = $request->input('email');
        $user->is_active    = 1;
        $user->updater_id   = $admin_id;
        $user->created_at     = now();
        if($request->input('avatar')){
            $avatar = FileUpload::forwardFile($request->input('avatar'), 'mo');
            if($avatar != ""){
                $user->avatar = $avatar; 
            }
        }
        $user->save();

        $data = Main::findOrFail($id);
        $data->user_id              = $user_id;
        $data->name                   = $request->input('mo_name');
        $data->description                   = $request->input('description');
        $data->updated_at           = now();
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
