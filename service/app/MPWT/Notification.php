<?php

namespace App\MPWT;

use App\Http\Controllers\Controller;
use App\Model\User\Main as User;
use App\Model\User\Notification as UserNotification;
use App\MPWT\Firebase;
use App\MPWT\SMS;
use App\MPWT\Email;


class Notification extends Controller
{
    
    public static function send($userId = 0, $metaData = ['way'=>'phone', 'title'=>'Hello from MPWT', 'description'=>'']){
        $user = User::find($userId); 
        if($user){
            if(isset($metaData['way']) && isset($metaData['title']) && isset($metaData['description'])){
                
                $data               = new UserNotification; 
                $data->user_id      = $user->id;
                $data->title        = $metaData['title']; 
                $data->description  = $metaData['description']; 
                $data->type         = $metaData['type']; 

                $extra = []; 

                if($metaData['action']){
                     $data->action      = $metaData['action']; 
                     $extra['action']   = $metaData['action']; 
                     if($metaData['action_id']){
                        $data->action_id        = $metaData['action_id'];
                        $extra['action_id']     = $metaData['action_id']; 
                     }
                }

                if(isset($metaData['image']) && $metaData['image'] != ""){
                    $data->image = $metaData['image']; 
                }

                if($metaData['way'] == 'phone'){
                    $data->way = 'phone'; 
                    
                    //Start to send via phone
                }elseif($metaData['way'] == 'firebase'){
                    $data->way = 'firebase'; 

                    //Start to send via Firebase
                    if($user->app_token != ""){
                        Firebase::send([$user->app_token], $metaData['title'], $metaData['description'], $extra); 
                    }
                    
                }


                $data->save(); 

                return ['status'=>'success', 'message'=>'Message has been sent']; 

            }else{
                return ['status'=>'error', 'message'=>'Invalid meta data']; 
            }
                
        }else{
             return ['status'=>'error', 'message'=>'Invalid user']; 
        }
    }

   
 
}
