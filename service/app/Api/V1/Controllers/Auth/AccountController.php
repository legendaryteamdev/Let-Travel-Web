<?php

namespace App\Api\V1\Controllers\Auth;

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
use App\MPWT\SMS;
use Carbon\Carbon;
//========================== Use Mail
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;
use App\MPWT\FileUpload;

class AccountController extends ApiController
{
    function view(){
        $auth = JWTAuth::parseToken()->authenticate();
        $admin = Main::select('*')->where('id', $auth->id)->first();
        return response()->json($admin, 200);
    }
    public function getSecurityCode(Request $request) {
        
        //====================================>> Check Validation for all input data
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
            'purpose'   => [
                            'required'
                        ],
        ], [

                'phone.required'        =>  __('account.phone-required'), 
                'phone.regex'           =>  __('account.phone-regex'),

                'email.required'        =>  __('account.email-required'), 
                'email.email'           =>  __('account.email-email'), 
                'email.max'             =>  __('account.email-max'), 
                'purpose.required'      =>  __('account.purpose-required'), 
        ]);
        
        
         //====================================>> Fetching user data from database
        $user = User::where(['is_active'=>1, 'deleted_at'=>null]); 
        if(filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
            $user = $user->where('email', $request->post('email'))->first(); 
        }else{
            $user = $user->where('phone', $request->post('phone'))->first(); 
        }
        
        //====================================>> Check if having user
        if($user){
            
            $purpose = $request->post('purpose'); 

            $code = new Code; //Create a security code
            $code->user_id = $user->id; 
            $code->code = rand(100000, 999999); 
            $code->type = $purpose;
            $code->is_verified = 0; 
            $code->save();

            if($purpose == 'PASSWORD'){
                if(filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
                    
                    $notification = [
                        'name'      => $user->name,
                        'code'      => $code->code,
                    ];
                    Mail::to($user->email)->send(new Notification(__('account.password-notification'), $notification, 'emails.member.account.reset-password'));

                    return response()->json([
                        'status_code'   => 200,
                        'message'       => __('account.password-notification-message') 
                    ], 200);

                }else{
                    
                    $sms = SMS::sendSMS($user->phone, 'សូមប្រើប្រាស់លេខកូដនេះ :'.$code->code.' ដើម្បីផ្ទៀងផ្ទាត់សំណើរ។ សូមអគុណ!');
                    return response()->json([
                        'status_code'=> 200,
                        'message'=> __('account.password-nexmo-message')
                    ], 200);
                    
                }
                
                // if($user->is_email_verified == 1){

                //     $notification = [
                //         'name'      => $user->name,
                //         'code'      => $code->code,
                //     ];
                //     Mail::to($user->email)->send(new Notification(__('account.password-notification'), $notification, 'emails.member.account.reset-password'));

                //     return response()->json([
                //         'status_code'   => 200,
                //         'message'       => __('account.password-notification-message') 
                //     ], 200);

                // }else if($user->is_phone_verified == 1){

                //     $sms = SMS::sendSMS($user->phone, 'សូមប្រើប្រាស់លេខកូដនេះ :'.$code->code.' ដើម្បីផ្ទៀងផ្ទាត់សំណើរ។ សូមអគុណ!');
                //     return response()->json([
                //         'status_code'=> 200,
                //         'message'=> __('account.password-nexmo-message')
                //     ], 200);

                // }else{
                //     return response()->json([
                //         'status_code'   =>  403,
                //         'errors'        =>  ['message'  =>  [__('account.password-nexmo-error')]]
                //     ], 403);
                // }
            }else if($purpose == 'ACTIVATE'){

                if(filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
                    if($user->is_email_verified != 1){
                        
                        $notification = [
                            'name'      => $user->name,
                            'code'      => $code->code,
                        ];
                        Mail::to($user->email)->send(new Notification(__('account.activate-notification'), $notification, 'emails.member.account.verify-code'));

                        return response()->json([
                            'status_code'   => 200,
                            'message'=> __('account.activate-notification-message')
                        ], 200);

                    }else{
                        return response()->json([
                            'status_code'   =>  403,
                            'errors'        =>  ['message'  =>  [__('account.activate-notification-error')]]
                        ], 403);
                    }

                       
                }else{
                    if($user->is_phone_verified != 1){
                        
                        $sms = SMS::sendSMS($user->phone, 'សូមប្រើប្រាស់លេខកូដនេះ :'.$code->code.' ដើម្បីផ្ទៀងផ្ទាត់សំណើរ។ សូមអគុណ!');
                        return response()->json([
                            'status_code'   => 200,
                            'message'=> __('account.activate-nexmo-message')
                        ], 200);
                    }else{
                        return response()->json([
                            'status_code'   =>  403,
                            'errors'        =>  ['message'  =>  [__('account.activate-nexmo-error')]]
                        ], 403);
                    }
                        
                }

            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  [__('account.code-purpose-error')]]
                ], 403);
            }
                 
        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  [__('account.no-phone-email')]]
            ], 403);
        }
    }

    public function verifyCode(Request $request) {
        
        //====================================>> Check Validation for all input data
        $this->validate($request, [
            'code'      => 'required|min:6|max:6',
            'purpose'   => 'required',
        ], [

                'code.required'             =>  __('account.code-required'), 
                'code.length'               =>  __('account.code-length'),
                'purpose.required'          => __('account.code-purpose')
        ]);
        
        $code = $request->post('code'); 
        $data = Code::where(['code'=>$code, 'type'=>$request->post('purpose')])->orderBy('id', 'DESC')->first(); 
        $totalMinutesDifferent = 0;
        
        if($data){
            
            //====================================>> Check if expired
            $created_at = Carbon::parse($data->created_at);
            $now = Carbon::now(env('APP_TIMEZONE')); 
            $totalMinutesDifferent = $now->diffInMinutes($created_at);

            if($totalMinutesDifferent < 30){
                $user = User::findOrFail($data->user_id);
                if($user){
                    
                    //====================================>> Updated Code
                    $code = Code::find($data->id); 
                    if($code->is_verified == 0){
                        $code->is_verified = 1; 
                        $code->verified_at = now(); 
                        $code->save();

                        if($request->post('purpose') == 'ACTIVATE'){
                            if(!is_null($user->email)){

                                $user->is_email_verified        = 1; 
                                $user->email_verified_at        = now(); 
                                $user->email_verified_code      = $request->post('code'); 
                                $user->save(); 

                            }else if(!is_null($user->phone)){

                                $user->is_phone_verified        = 1; 
                                $user->phone_verified_at        = now(); 
                                $user->phone_verified_code      = $request->post('code'); 
                                $user->save(); 

                            }
                        }else if($request->post('purpose') == 'PASSWORD'){
                            if(!is_null($user->email)){

                                $user->is_email_verified        = 1;  
                                $user->email_verified_code      = $request->post('code'); 
                                $user->save(); 

                            }else if(!is_null($user->phone)){

                                $user->is_phone_verified        = 1; 
                                $user->phone_verified_code      = $request->post('code'); 
                                $user->save(); 

                            }
                        }

                        //====================================>> Crate token
                        $token = JWTAuth::fromUser($user);
                        $user = JWTAuth::toUser($token);
                        return response()->json([
                            'token'             => $token,
                            'roles'         =>  $this->checkUserPosition($user->id), 
                            'user'              => $user,
                            'status_code'       =>  200,
                            'message'           => __('account.code-message') ,
                        ], 200);
                    }else{
                         return response()->json([
                            'status_code'=> 403,
                            'errors'        =>  ['message'  =>  [__('account.code-error')]]
                        ], 403);
                    }
                }else{
                    return response()->json([
                        'status_code'=> 403,
                        'errors'        =>  ['message'  =>  [__('account.user-error')]]
                    ], 403);
                }
            }else{
                return response()->json([
                    'status_code'=> 403,
                    'errors'        =>  ['message'  =>  [__('account.expired-code')]]
                ], 403);
            } 
        }else{
            return response()->json([
                'status_code'=> 403,
                'errors'        =>  ['message'  =>  [__('account.code-wrong')]]
            ], 403);
        }
    }

    public function resetPassword(Request $request) {
        
        //====================================>> Check Validation for all input data
        $this->validate($request, [
            'password' => 'required|min:6|max:60'
        ],[
            'password.required'     =>  __('account.reset-password-required'),
            'password.min'          =>  __('account.reset-password-min'),
            'password.max'          =>  __('account.reset-password-max'),
        ]);
        
        $token = $request->get('token'); //submited by query string ?token={{value}}
        $password = $request->post('password');
        $user = JWTAuth::toUser($token);
        
        if($user){
            $user = User::findOrFail($user->id);
            $user->password_last_updated_at = now();
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'status_code'=> 200,
                'message'=>__('account.reset-message')
            ], 200);
        }else{
            return response()->json([
                'status_code'=> 403,
                'errors'        =>  ['message'  =>  [__('account.reset-token')]]
            ], 200);
        }      
    }

    public function updateProfile(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [
            'name'      => 'required|max:60',
            'phone'     =>  [
                            'sometimes', 
                            'required',  
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                            Rule::unique('user', 'phone')->ignore($user->id)
                        ],
            'email'     =>   [
                            'sometimes', 
                            'required', 
                            'email', 
                            'max:50', 
                            Rule::unique('user', 'email')->ignore($user->id)
                        ]
           

        ], [
                'name.required'         =>  __('account.profile-name-required'),
                
                'phone.unique'          =>  __('account.profile-phone-unique'),
                'phone.required'        =>  __('account.profile-phone-required'), 
                'phone.regex'           =>  __('account.profile-phone-regex'),

                'email.required'        =>  __('account.profile-email-required'), 
                'email.email'           =>  __('account.profile-email-email'), 
                'email.max'             =>  __('account.profile-email-max'), 
                'email.unique'          =>  __('account.profile-email-unique')

            ]);

        //====================================>> Find existing user
        $user = User::find($user->id);

        $user->name         = $request->input('name');
        if($user->is_email_verified != 1){
            $user->email        = $request->input('email');
        }
        if($user->is_phone_verified != 1){
           $user->phone        = $request->input('phone');
        }
        
        if($request->input('avatar')){
            $user->avatar       = FileUpload::forwardFile($request->input('avatar'), 'pothole');
        }
        
        $user->save();

        return response()->json([
            'status_code'        => 200,
            'message'       => __('account.profile-message'),
            'user' => $user
        ], 200);   
    }

    public function changePassword(Request $request) {
        
        //====================================>> Check Validation for all input data
        $this->validate($request, [
            'old_password'  => 'required|min:6|max:60',
            'password'      => 'required|min:6|max:60:confirmed',
        ], [
            'old_password.required'     =>  __('account.old-password-required'),
            'old_password.min'          =>  __('account.old-password-min'),
            'old_password.max'          =>  __('account.old-password-max'),

            'password.required'     =>  __('account.change-password-required'),
            'password.min'          =>  __('account.change-password-min'),
            'password.max'          =>  __('account.change-password-max'),
            'password.confirmed'    =>  __('account.change-password-confirmed')
        ]);
        

        $user = JWTAuth::toUser($request->get('token'));

        $credentails = [
            'password'=>$request->post('old_password'), 
            'is_active'=>1, 
            'deleted_at'=>null
        ];

        if($user->is_phone_verified == 1){
            $credentails['phone'] =  $user->phone; 
        }elseif($user->is_email_verified == 1){
            $credentails['email'] =  $user->email; 
        }

        //return $credentails; 
        try{
            if($token = JWTAuth::attempt($credentails)){//This mean that password submitted is correct
                
                $user = User::findOrFail($user->id);
                $user->password_last_updated_at = now();
                $user->password = bcrypt($request->input('password'));
                $user->save();

                return response()->json([
                    'status_code'=> 200,
                    'message'=>__('account.change-password-message')
                ], 200);

            }else{
                return response()->json([
                    'status_code'=> 403,
                    'errors'        =>  ['message'  =>  [__('account.invalid-old-password')]]
                ], 403);
            }

        } catch(JWTException $e){
            return response()->json([
                'status_code'   =>  500, 
                'errors'        =>  ['message'  =>  [__('login.no-token')]]
            ], 500);
        }     
    }

    public function delete(Request $request) {
        $user = User::where('email', $request->input('username'))->orWhere('phone', $request->input('username'))->first(); 
    
        if($user){
            $user->delete(); 
            return response()->json([
                'status_code'=> 200,
                'message'=>__('account.deleted-message')
            ], 200);
         }else{
               return response()->json([
                'status_code'=> 422,
                'errors'        =>  ['message'  =>  [__('account.deleted-error')]]
            ], 422);
         }  
    }

    public function refreshToken(Request $request) {
        $newToken = JWTAuth::refresh();
        return response()->json([
            'token' => $newToken,
            'status_code'=> 200,
            'message'=>__('account.refresh-token'),
        ], 200);
    }


}
