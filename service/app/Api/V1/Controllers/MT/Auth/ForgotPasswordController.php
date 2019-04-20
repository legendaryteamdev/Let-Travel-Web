<?php

namespace App\Api\V1\Controllers\MT\Auth;

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
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;
use App\MPWT\SMS;

class ForgotPasswordController extends ApiController
{

    public function getResetPasswordCode(Request $request) {
        
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
                        ]
        ], [
            
            'phone.regex' => 'Please enter valid phone number or email.', 
            'email.regex' => 'Please enter valid phone number or email.', 
            'email.email' => 'Please enter valid email address.'
        ]);
        
       
        $credentails = array('is_active'=>1, 'type_id'=>2, 'deleted_at'=>null); 
        $email = $request->post('email'); 
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $credentails['email'] =  $email;
        }else{
            $credentails['phone'] =  $request->post('phone'); 
        }

        $user = User::where($credentails)->first(); 
        if($user){
           
            $code = new Code; //Create a security code
            $code->user_id = $user->id; 
            $code->code = rand(100000, 999999); 
            $code->type = 'PASSWORD';
            $code->is_verified = 0; 
            $code->save();


           if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    
                $notification = [
                    'name'      => $user->name,
                    'code'      => $code->code,
                ];
                Mail::to($user->email)->send(new Notification(__('account.password-notification'), $notification, 'emails.member.account.reset-password'));

                return response()->json([
                    'status'        => 'success',
                    'tool'          => $email,
                    'message'       => __('account.password-notification-message') 
                ], 200);

            }else{
                
                $sms = SMS::sendSMS($user->phone, 'សូមប្រើប្រាស់លេខកូដនេះ :'.$code->code.' ដើម្បីផ្ទៀងផ្ទាត់សំណើរ។ សូមអគុណ!');
                return response()->json([
                    'status'        => 'success',
                    'tool'          => $request->post('phone'), 
                    'message'=> __('account.password-nexmo-message')
                ], 200);
                
            }

        }else{
            return response()->json([
                'status'=> 'error',
                'errors'        =>  ['message'  =>  ['There is no any account related with provided information.']]
            ], 403);
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
                        'message' => 'Security code verified.',
                        'token'=> $token 
                    ], 200);


                }else{
                     return response()->json([
                        'errors'        =>  ['message'  =>  ['Invalid user']]
                    ], 403);
                }
            }else{
                return response()->json([
                    'errors'        =>  ['message'  =>  ['Code expired']]
                ], 403);
            }
                
        }else{
            return response()->json([
                'errors'        =>  ['message'  =>  ['Invalid code']]
            ], 403);
        }
       
    }

    public function changePassword(Request $request) {
        
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ], [
            'password.confirmed' => 'Please invalid password confirmation.'
        ]);
        
        $token = $request->post('token'); 
        $password = $request->post('password');
        $user = JWTAuth::toUser($token);
        if($user){

            $user = User::findOrFail($user->id);
            $user->password_last_updated_at = now();
            $user->password = bcrypt($request->input('password'));
            $user->save(); 
             
            return response()->json([
                'message'=>'Your password has been changed.'
            ], 200);
        }else{
            return response()->json([
                'errors'        =>  ['message'  =>  ['Invalid token']]
            ], 403);
        }

           


    }


    


}
