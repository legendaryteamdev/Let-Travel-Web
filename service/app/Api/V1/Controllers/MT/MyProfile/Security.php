<?php

namespace App\Api\V1\Controllers\MT\MyProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main;
use App\Model\User\Code as Code;

use App\Model\Admin\Admin as Model;
use App\Model\Member\Main as Member;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use PragmaRX\Google2FA\Google2FA;


//========================== Use Mail
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;

class Security extends ApiController
{
    use Helpers;
    
    //======================================================================================>> Email Verification
    function sendEmailVerifyCode(){
        $user = JWTAuth::parseToken()->authenticate();
        //===================================================>> Create Verify Code
        $data = New Code;
        $data->user_id      = $user->id;
        $data->type         = "Email-Verify"; 
        $data->code         = $this->generateVerificationCode();
        $data->is_verified  = 0;
        $data->save(); 

        //===================================================>> Send Email Notification to company
        $notification = [
            'name'      => $user->name, 
            'code'      => $data->code
        ];
        Mail::to($user->email)->send(new Notification('ការផ្ទៀងផ្ទាត់តាមរយៈអ៊ីម៉ែល', $notification, 'emails.member.account.verify-email'));

        return response()->json([
                'status' => 'success',
                'message' => 'សូមពិនិត្យមើលអីុម៉ែលរបស់លោកអ្នកដើម្បីធ្វើការផ្ទៀងផ្ទាត់. អគុណ!!!'
            ], 200);   
    }

    function verifyEmail(Request $request){
        $code = $request->input('code');
        $data = Code::where(['code'=>$code, 'type'=>'Email-Verify'])->first(); 


        if($data){ //Check if it valid. 
            $now    = date_create(now());
            $date   = date_create($data->created_at);
            $interval = date_diff($now, $date);
            
            if($interval->i < 30){ //Check if code has been verified
                if($data->is_verified == 0){ //Check if code has been verified

                    $data->is_verified = 1; 
                    $data->verified_at = now(); 
                    $data->save(); 

                    //Update email to be verify. 
                    $user = Main::findOrFail($data->user_id); 
                    $user->is_email_verified = 1; 
                    $user->email_verified_code = $code; 
                    $user->email_verified_at = now(); 
                    $user->save(); 

                    //Send Notification
                    $notification = [
                        'name'      => $user->name
                    ];
                    Mail::to($user->email)->send(new Notification('ការផ្ទៀងផ្ទាត់តាមរយៈអ៊ីម៉ែល', $notification, 'emails.member.account.verify-email-success'));

                    return response()->json([
                        'status' => 'success',
                        'message' => 'អីុម៉ែលត្រូវបានផ្ទៀងផ្ទាត់ជោគជ័យ ',
                    ], 200);   

                }else{
                    return response()->json([
                        'status' => 'code-already-used',
                        'message' => 'អីុម៉ែលរបស់លោកអ្នកត្រូវបានប្រើប្រាស់រួចរាល់ហើយ ។ សូមព្យាយាមម្តងទៀត',
                    ], 200);   
                }
            }else{
                return response()->json([
                    'status' => 'code-expired',
                    'message' => 'កូដត្រូវបានផុតកំណត់ ។ សូមព្យាយាមម្តងទៀត',
                ], 200);   
            }
        }else{
            return response()->json([
                'status' => 'code-valid',
                'message' => 'កូដមិនត្រឹមត្រូវទេ ។ សូមព្យាយាមម្តងទៀត ',
            ], 200);   
        }
    }
    //======================================================================================>> Check Telegram Account
    function checkTelegramAccount(){
        $user = JWTAuth::parseToken()->authenticate();
        $phone = $user->phone; 

        return response()->json([
            'status' => 'success',
            'message' => 'Member has Telegram Account'
        ], 200);   
    }

    //======================================================================================>> Google Auth
    function getGoogle2FAQR(){
        $user = JWTAuth::parseToken()->authenticate();
        
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        // $user->google2fa_secret = $secret; 
        // $user->save(); 

        $inlineUrl = $google2fa->getQRCodeInline('richycapital.com',  $user->email, $secret );

        return response()->json([
            'inlineUrl' => $inlineUrl,
            'secret'    => $secret,
        ], 200);   
    }
    
    function verifyGoogle2FA(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $code = $request->input('code');
        $secret = $request->input('secret');
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $code);
        if( $valid){

            $user->google2fa_secret = $secret; 
            $user->is_google2fa_enable = 1;
            $user->google2fa_enable_at = now(); 
            $user->save(); 

             return response()->json([
                'status' => 'success',
                'message' => 'You have successfully enabled Google Authenticator.'
            ], 200);   
         }else{
             return response()->json([
                'status' => 'error',
                'message' => 'Sorry! You are not able to enable Google Authenticator. Please try again.'
            ], 200);   
         }

       
    }

    function disableGoogle2FA(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $code = $request->input('code');
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($user->google2fa_secret, $code);
        if( $valid){

            $user->is_google2fa_enable = 0;
            $user->google2fa_secret = ''; 
            $user->save(); 

             return response()->json([
                'status' => 'success',
                'message' => 'You have successfully disable Google Authenticator.'
            ], 200);   
         }else{
             return response()->json([
                'status' => 'error',
                'message' => 'Sorry! You are not able to disable Google Authenticator. Please try again.'
            ], 200);   
         }

       
    }



}
