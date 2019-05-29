<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User;
use App\Model\User\Code;
use App\Model\Member\Main as Member;
use JWTAuth;
use App\MPWT\SMS;


//========================== Use Mail
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;

class RegisterController extends ApiController
{

    public function register(Request $request) {
       
        $this->validate($request, [
            'name'      => 'required|max:60',
            'phone'     =>  [
                            'sometimes', 
                            'required',  
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                            Rule::unique('user', 'phone')
                        ],
            'email'     =>   [
                            'sometimes', 
                            'required', 
                            'email', 
                            'max:50', 
                            Rule::unique('user', 'email')
                        ],
            'password'  => 'required|min:6|max:60|confirmed', 

            'socialType'  => [
                            'sometimes', 
                            'required'
                        ],
            'socialId'  => [
                            'sometimes', 
                            Rule::unique('user', 'social_id')
                        ]
        ],  [
                'name.required'         =>  __('register.name-required'),
                
                'phone.unique'          =>  __('register.phone-unique'),
                'phone.required'        =>  __('register.phone-required'), 
                'phone.regex'           =>  __('register.phone-regex'),

                'email.required'        =>  __('register.email-required'), 
                'email.email'           =>  __('register.email-email'), 
                'email.max'             =>  __('register.email-max'), 
                'email.unique'          =>  __('register.email-unique'), 

                'password.required'     =>  __('register.password-required'),
                'password.min'          =>  __('register.password-min'),
                'password.max'          =>  __('register.password-max'), 
                'password.confirmed'    =>  __('register.password-confirmed'), 

                'socialId.unique'       =>  __('register.social-id-unique'), 
                'socialType.required'   =>  __('register.social-id-type'), 
        ]);

        //====================================>> Create New user
        $user = new User();
        $user->type_id          = 4; //RU:Road User
        
        $user->name             = $request->input('name');
        $user->phone            = $request->input('phone');
        $user->email            = $request->input('email');
        $user->is_active        = 1;
        $user->social_type_id   = 1;
        
        $user->password         = bcrypt($request->input('password'));
        $user->avatar           = 'public/user/profile.png';

        
        if($request->input('socialType') && $request->input('socialId')){
            if($request->input('socialType') == 2 || $request->input('socialType') == 3){
               $user->social_type_id    = $request->input('socialType'); 
               $user->social_id         = $request->input('socialId');

               //====================================>> Make email or phone verified
                if(filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
                    $user->is_email_verified = 1;
                }else{
                    $user->is_phone_verified = 1;
                }

            }
        }

        $user->save();

        //====================================>> Create New RU
        $member                           = new Member();
        $member->user_id                  = $user->id;
        $member->save();

        if($request->input('socialType') != 2 && $request->input('socialType') != 3){//Need to verify account if not using social account.
            $code = new Code; 
            $code->user_id = $user->id; 
            $code->code = rand(100000, 999999); 
            $code->type = 'ACTIVATE';
            $code->is_verified = 0; 
            $code->save();

            //====================================>> Send welcome and activation
            if(filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)){
                $notification       = [
                    'member'        => $user->name,
                    'email'         => $user->email,
                    'phone'         => $user->phone, 
                    'code'          => $code->code
                ];
                Mail::to($user->email)->send(new Notification(__('register.notification'), $notification, 'emails.member.account.welcome'));

                return response()->json([
                    'status_code'   => 200,
                    'message'       => __('register.notification-message'),
                ], 200);   

            }else{
                
                $sms = SMS::sendSMS($user->phone, 'សូមប្រើប្រាស់លេខកូដនេះ :'.$code->code.' ដើម្បីផ្ទៀងផ្ទាត់គណនី។ សូមអគុណ!');
                return response()->json([
                    'status_code'   => 200,
                    'message'       => __('register.nexmo-message'),
                ], 200);   
            }
        }else{
            
            return response()->json([
                'token'         => JWTAuth::fromUser($user), 
                'roles'         =>  $this->checkUserPosition($user->id), 

                'status_code'   => 200,
                'message'       => __('register.register-success'),
            ], 200); 
        }
               
    }

   

}
