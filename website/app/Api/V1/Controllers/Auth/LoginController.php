<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\CamCyber\AgentController as Agent;
use App\CamCyber\IpAddressController as IpAddress;
use App\Model\User\Log;
use App\Model\User\Main as User;
use App\Model\Member\Main as Member;
use JWTAuth;

class LoginController extends ApiController
{

    public function login(Request $request) {
        $token = ''; 

        if($request->input('socialType') && $request->input('socialId')){ //Determine if having any social information submitted.
            if($request->input('socialType') == 2 || $request->input('socialType') == 3){ //Facebook or Google
                
                $user = User::where([
                    'social_type_id'    =>  $request->input('socialType'), 
                    'social_id'         =>  $request->input('socialId'), 
                    'deleted_at'        =>  null, 
                    'is_active'         =>  1
                ])->first(); 

                if($user){
                    $token = JWTAuth::fromUser($user);
                }else{
                    
                    //Check if one of credentail information is provided
                    if($request->input('email') || $request->input('phone')){
                        $newUser = new User;

                        //Additional Check if having valid email (format) provided from social
                        if($request->input('email') && filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
                            //Check if an user has this email
                            $user = User::where(['email'=>$request->post('email'), 'is_email_verified'=>1, 'is_active'=>1])->first(); 
                            //Update Social information
                            if($user){
                                $user->social_type_id   = $request->input('socialType'); 
                                $user->social_id        = $request->input('socialId');
                                $user->save(); 
                                $token = JWTAuth::fromUser($user);    
                            }else{
                                $newUser->email                = $request->post('email'); 
                                $newUser->is_email_verified    = 1; 
                            }
                        }

                        //Additional Check if having phone from social
                        if($request->input('phone') && preg_match('/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', $request->post('phone'))){
                            //Update Social ID & Type
                            $user = User::where(['phone'=>$request->post('phone'), 'is_phone_verified'=>1, 'is_active'=>1])->first(); 
                            if($user){
                                $user->social_type_id   = $request->input('socialType'); 
                                $user->social_id        = $request->input('socialId');
                                $user->save(); 

                                $token = JWTAuth::fromUser($user); 
                            }else{
                                $newUser->phone                = $request->post('phone'); 
                                $newUser->is_phone_verified    = 1; 
                            }
                        }

                        //Register new account via social information
                        if(  $token == "" ){

                            //Create New User
                            $newUser->name                 = $request->post('name'); 
                            $newUser->type_id              = 4;//RU 
                            $newUser->social_type_id       = $request->input('socialType'); 
                            $newUser->social_id            = $request->input('socialId');
                            $newUser->password             = bcrypt(rand(100000, 999999));
                            $newUser->avatar               = 'public/user/profile.png';
                            $newUser->save();

                            // //Create New RU
                            $member                           = new Member();
                            $member->user_id                  = $newUser->id;
                            $member->save();

                            $token = JWTAuth::fromUser($newUser); 
                        }
                    }

                    if($token == ''){
                        return response()->json([
                            'status_code'   =>  401, 
                            'message'       => 'invalid social information', 
                            'errors'        =>  ['message'  =>  [__('login.socail-login-fail')]]
                        ], 401);
                    }     
                }

            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'message'       => 'Invalid social type', 
                    'errors'        =>  ['message'  =>  [__('login.socail-login-invalid')]]
                ], 403);
            }

        }else{ //Then check on username (phone or email)
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

                    'phone.required'        =>  __('login.phone-required'), 
                    'phone.regex'           =>  __('login.phone-regex'),

                    'email.required'        =>  __('login.phone-required'), 
                    'email.email'           =>  __('login.email-email'), 
                    'email.max'             =>  __('login.email-max'), 

                    'password.required'     =>  __('login.password-required'),
                    'password.min'          =>  __('login.password-min'),
                    'password.max'          =>  __('login.password-max'),
            ]);

            $credentails = [
                'password'=>$request->post('password'), 
                'is_active'=>1, 
                'deleted_at'=>null
            ];

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
                        'message'       => 'invalid username and password', 
                        'errors'        =>  ['message'  =>  [__('login.info-not-match')]]
                    ], 401);
                }

            } catch(JWTException $e){
                return response()->json([
                    'status_code'   =>  500, 
                    'message'       => 'token could not be generated.', 
                    'errors'        =>  ['message'  =>  [__('login.no-token')]]
                ], 500);
            }
        }
            
       
       $user = JWTAuth::toUser($token);
       
        //Log Information
        //$agent      = new Agent;
        //$info       = $agent::showInfo();
        $ipAddress  = new IpAddress;
        $ip         = $ipAddress::getIP(); 

        //Save Logs
        $log = new Log;
        $log->user_id   = $user->id;
        $log->ip        = $ip;
        // $log->os        = $info['os'];
        // $log->tool   = $info['browser'];
        // $log->version   = $info['version'];
        $log->save();

        if( $user->is_phone_verified == 1 || $user->is_email_verified == 1 ){
            return response()->json([
                'token'         =>  $token, 
                'roles'         =>  $this->checkUserPosition($user->id), 
                'user'          => $user,
                'status_code'   =>  200, 
                'message'       =>  __('login.login-success')
            ], 200);
        }else{
            return response()->json([
                'status_code'   =>  403,
                'message'       => 'account activation required', 
                'errors'        =>  ['message'  =>  [__('login.login-fail')]]
            ], 403);
        }
          
    }


}
