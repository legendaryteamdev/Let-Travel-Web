<?php

namespace App\MPWT;

use App\Http\Controllers\Controller;

class Firebase extends Controller
{
    

    public static function send($tokens = [], $title = 'Hello from MPWT', $body = '', $extra = []){
        
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        

        $notification = [
            'title' => $title,
            'body'  => $body,
            'sound' => true,
        ];
        

        $fcmNotification = [
            'notification' => $notification,
            'data' => $extra
        ];

        if(count($tokens) == 1){
        	$fcmNotification['to'] = $tokens[0]; 
        }elseif(count($tokens) > 1){
        	$fcmNotification['registration_ids'] = $tokens; 
        }

        $headers = [
            'Authorization: key='.env('FCM_KEY'),
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }

 
}
