<?php

namespace App\Api\V1\Controllers\CP\MyProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main;

use App\Model\Admin\Admin as Model;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

class Controller extends ApiController
{
    use Helpers;
    function get(){
        $auth = JWTAuth::parseToken()->authenticate();
        $admin = Main::select('*')->where('id', $auth->id)->first();
        return response()->json($admin, 200);
    }

    function put(Request $request){
         $user_id = JWTAuth::parseToken()->authenticate()->id;
        
        $this->validate($request, [
            'name' => 'required|max:60',
            'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                            Rule::unique('user')->ignore($user_id)
                        ],
        ]);
        //========================================================>>>> Start to update user
        $user = Main::find($user_id);
        if($user){
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            // $user->telegram_chat_id = $request->input('telegram_id');
            $user->updated_at = now();
            //Start to upload image to that director
            
            if($request->input('avatar')){
                $avatar = FileUpload::forwardFile($request->input('avatar'), 'profile');
                if($avatar != ""){
                    $user->avatar = $avatar; 
                }
            }
            $user->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'ទិន្នន័យត្រូវកែប្រែ!', 
                'data' => $user
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'ព្យាយាមម្តងទៀត'
            ], 200);   
        }
      

    }
  
    function changePassword(Request $request){
        $old_password = $request->input('old_password');
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        //dd($user_id);
       $current_password = Main::find($user_id)->password;
        

       if (password_verify($old_password, $current_password)){ 
            
            $this->validate($request, [
                            'password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:password',
            ]);

            $id=0;
            //========================================================>>>> Start to update user
            $user = Main::findOrFail($user_id);
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'ទិន្នន័យត្រូវកែប្រែ!'
            ], 200);
        }else{
         return response()->json([
                'status' => 'error',
                'message' => 'លេខសម្ងាត់ចាស់មិនត្រឹមត្រូវទេ! សូមបញ្ជូលម្តងទៀត'
            ], 200);   
        }
        

    }

}
