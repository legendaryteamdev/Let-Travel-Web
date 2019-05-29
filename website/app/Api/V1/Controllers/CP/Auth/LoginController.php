<?php

namespace App\Api\V1\Controllers\CP\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\CamCyber\AgentController as Agent;
use App\CamCyber\IpAddressController as IpAddress;
use App\Model\User\Log;
use App\Model\User\Code;
use App\Model\User\Main as User;
use JWTAuth;
use TelegramBot;
use Carbon\Carbon;

class LoginController extends ApiController
{

    public function login(Request $request) {
        
        $this->validate($request, [
             'phone' =>  [
                            'sometimes',
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/'
                        ],
            'email'     =>   [
                            'sometimes', 
                            'required', 
                            'email', 
                            'max:100'
                        ],
            'password' => 'required|min:6|max:60',
        ]);

        $credentails = array('email'=>$request->post('email'), 'password'=>$request->post('password'), 'is_active'=>1, 'type_id'=>1, 'deleted_at'=>null); 

        try{
            if(!$token = JWTAuth::attempt($credentails)){
                
                return response()->json([
                    'error' => 'Invalid Credentails!'
                ], 401);
            }

        } catch(JWTException $e){
            return response()->json([
                'error' => 'Could not create token!'
            ], 500);
        }


       $user = JWTAuth::toUser($token);
       
         //Log Information
        $agent      = new Agent;
        $info       = $agent::showInfo();
        $ipAddress  = new IpAddress;
        $ip         = $ipAddress::getIP(); 

        //Save Logs
        $log = new Log;
        $log->user_id   = $user->id;
        $log->ip        = $ip;
        $log->os        = $info['os'];
        $log->tool   = $info['browser'];
        $log->version   = $info['version'];
        //$log->save();

        
        //Notify user for login
        // if($user->is_notified_when_login){
        //     if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
        //         $response = TelegramBot::sendMessage([
        //           'chat_id' => $user->telegram_chat_id, 
        //           'text' => '<b>New Logged In Information</b>: You have logged to system with following information,
        //                     IP Address: <code>'.$log->ip.'</code>,
        //                     Operating System: <code>'.$log->os.'</code>,
        //                     Tool: <code>'.$log->tool.'</code>,
        //                     Version: <code>'.$log->version.'</code>,
        //                     Date and Time: '.now().'
        //                     Please review it something went wrong. Thanks
        //                     ',
        //           'parse_mode' => 'HTML'
        //         ]);

        //     }
        // }

         //Check if this is new browser never used in 30 days
        // $check = Log::select('*')->where(['user_id'=>$user->id, 'ip'=>$log->ip, 'os'=>$log->os, 'tool'=>$log->tool, 'version'=>$log->version]); 
        // $check = $check->where('created_at', '>=', Carbon::now()->subDays(30).' 00:00:00')->get();
        // if(count($check) == 0){
        //      if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
        //         $code = new Code; 
        //         $code->user_id = $user->id; 
        //         $code->code = uniqid();
        //         $code->type = 'DEVICE';
        //         $code->is_verified = 0; 
        //         $code->save(); 

        //         $response = TelegramBot::sendMessage([
        //           'chat_id' => $user->telegram_chat_id, 
        //           'text' => '<b>Security Allert</b>: We have found that, you recently have logged to system with new device. Please use this code: <b>'.$code->code.'</b> to verify. Code is expired in 30 minues. Thanks',
        //           'parse_mode' => 'HTML'
        //         ]);



        //         return response()->json([
        //             'status'=> 'unauthorization-device',
        //         ], 200);
        //     }
        // }


       

       
        

        
        return response()->json([
            'status'=> 'success',
            'token'=> $token 
        ], 200);
    }
    


}
