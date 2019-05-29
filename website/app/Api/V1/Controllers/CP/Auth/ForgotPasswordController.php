<?php

namespace App\Api\V1\Controllers\CP\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\CamCyber\AgentController as Agent;
use App\CamCyber\IpAddressController as IpAddress;
use App\Model\User\Code;
use App\Model\User\Main as User;
use App\Model\User\Log;
use JWTAuth;
use TelegramBot;
use Carbon\Carbon;


class ForgotPasswordController extends ApiController
{

    public function getResetPasswordCode(Request $request) {
        
        $this->validate($request, [
             'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/'
                        ],
        ]);
        
        $phone = $request->post('phone'); 

        $user = User::where(['phone'=>$phone, 'is_active'=>1, 'type_id'=>1, 'deleted_at'=>null])->first(); 
       
        if($user){
            if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                $code = new Code; 
                $code->user_id = $user->id; 
                $code->code = uniqid();
                $code->type = 'PASSWORD';
                $code->is_verified = 0; 
                $code->save(); 

                $response = TelegramBot::sendMessage([
                  'chat_id' => $user->telegram_chat_id, 
                  'text' => '<b>Security Allert</b>: We have received request for resetting your password. Please use this code: <b>'.$code->code.'</b> to verify. Code is expired in 30 minues. Thanks',
                  'parse_mode' => 'HTML'
                ]);

                  return response()->json([
                    'status'=> 'success',
                    'message'=> 'code-sent' 
                ], 200);

            }else{
                return response()->json([
                    'status'=> 'error',
                    'message'=> 'no-way-to-send-code' 
                ], 200);
            }
               
        }else{
            return response()->json([
                'status'=> 'error',
                'message'=> 'user-not-found' 
            ], 200);
        }

    }



    public function verifyResetPasswordCode(Request $request) {
        
        $this->validate($request, [
            'code' => 'required|min:6',
        ]);
        
        $code = $request->post('code'); 

        $data = Code::where(['code'=>$code, 'type'=>'PASSWORD'])->orderBy('id', 'DESC')->first(); 
        $totalMinutesDifferent = 0;
        if($data){
            //Check if expired
            $created_at = Carbon::parse($data->created_at);
            $now = Carbon::now(env('APP_TIMEZONE')); 
            $totalMinutesDifferent = $now->diffInMinutes($created_at);

            if($totalMinutesDifferent < 30){
                $user = User::findOrFail($data->user_id);
                if($user){
                    
                    //Updated Code
                    $code = Code::find($data->id); 
                    $code->is_verified = 1; 
                    $code->verified_at = now(); 
                    $code->save(); 

                    //Crate token
                    $token = JWTAuth::fromUser($user);
                    return response()->json([
                        'status'=> 'success',
                        'token'=> $token 
                    ], 200);


                }else{
                     return response()->json([
                        'status'=> 'error',
                        'message'=> 'user-not-found' 
                    ], 200);
                }
            }else{
                return response()->json([
                    'status'=> 'error',
                    'message'=> 'code-expired'
                ], 200);
            }
                
        }else{
            return response()->json([
                'status'=> 'error',
                'message'=> 'code-not-valid' 
            ], 200);
        }

        
       
    }

    public function changePassword(Request $request) {
        
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        
        $token = $request->post('token'); 
        $password = $request->post('password');
        $user_id = JWTAuth::toUser($token)->id;

        $user = User::findOrFail($user_id);
        $user->password_last_updated_at = now();
        $user->password = bcrypt($request->input('password'));
        $user->save(); 

        if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
            $response = TelegramBot::sendMessage([
              'chat_id' => $user->telegram_chat_id, 
              'text' => '<b>Security Alert</b>: Your password has been changed!',
              'parse_mode' => 'HTML'
            ]);

        }

         
        return response()->json([
            'status'=> 'success',
            'message'=>'password-changed'
        ], 200);


    }


    


}
