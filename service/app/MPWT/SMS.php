<?php

namespace App\MPWT;

use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use Nexmo; 

class SMS extends Controller
{
    

    public static function sendSMSTwilio($receivNumber = '+855077677599', $message = 'Hello from MPWT'){
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $sms = $client->messages->create($receivNumber, ['from' => env('TWILIO_NUMBER'), 'body' => $message]);
        return $sms; 
    }


    public static function sendSMSNexmo($receivNumber = '85577677599', $message = 'Hello from MPWT'){
        $sms = $message = Nexmo::message()->send([
            'to'   => $receivNumber,
            'from' => env('APP_NAME'),
            'text' => $message
        ]);
        return $sms; 
    }

    public static function sendSMS($receivNumber = '077677599', $message = 'Hello from MPWT'){
        if(preg_match("/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/", $receivNumber)){
            if(env('SMS_CHOICE') == 'TWILIO'){
                if(env('TWILIO_SID') !== null && env('TWILIO_TOKEN') !== null ){
                    self::sendSMSTwilio('+855'.substr($receivNumber, 1), $message); 
                    return ['status'=>'success', 'message'=>'Message has been sent']; 
                }else{
                    return ['status'=>'error', 'message'=>'Invalid TWILIO config']; 
                }
            }else if(env('SMS_CHOICE') == 'NEXMO'){
                if(env('NEXMO_KEY') !== null  && env('NEXMO_SECRET') !== null ){
                    self::sendSMSNexmo('855'.substr($receivNumber, 1), $message); 
                    return ['status'=>'success', 'message'=>'Message has been sent']; 
                }else{
                    return ['status'=>'error', 'message'=>'Invalid NEXMO config']; 
                }
            }else{
                return ['status'=>'error', 'message'=>'No SMS provider']; 
            }
        }else{
           return ['status'=>'error', 'message'=>'Invalid number']; 
        }

            
    }
 
}
