<?php

namespace App\Api\V1\Controllers\MO\Auth;

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
        ], [
            'phone.regex' => 'Please enter valid phone number or email.', 
            'email.regex' => 'Please enter valid phone number or email.'
        ]);

        $credentails = array('password'=>$request->post('password'), 'is_active'=>1, 'type_id'=>2, 'deleted_at'=>null); 

        $email = $request->post('email'); 
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $credentails['email'] =  $email;
        }else{
            $credentails['phone'] =  $request->post('phone'); 
        }

        try{
            if(!$token = JWTAuth::attempt($credentails)){
                
                return response()->json([
                        'status_code'   =>  401, 
                        'errors'        =>  ['message'  =>  [__('login.info-not-match')]]
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
        $log->tool      = $info['browser'];
        $log->version   = $info['version'];
        //$log->save();


        return response()->json([
            'status'=> 'success',
            'token'=> $token 
        ], 200);
    }
    


}
