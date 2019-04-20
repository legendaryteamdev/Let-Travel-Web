<?php

namespace App\Api\V1\Controllers\Client\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;

use App\Model\User\Notification as UserNotification;
use JWTAuth;
use App\MPWT\Notification as Notify;


class Controller extends ApiController
{
    use Helpers;

    function updateAppToken(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        //return $user; 

        $this->validate($request, [ 
            'app_token'       => 'required|max:255', 
            'device'       => 'required|max:10'
        ], 
            [
                'app_token.required'  => 'Please enter your token', 
                'app_token.max'       => 'Max: 255'
            ]
        );

        $user->app_token = $request->input('app_token'); 
        $user->device = $request->input('device'); 
        $user->save(); 

        return response()->json([
                'message'       =>  'App token has been updated.', 
                'status_code' => 200
            ], 200);

    }

    function update(Request $request, $id = 0){
        $user = JWTAuth::parseToken()->authenticate();
        
        $data = UserNotification::where('user_id', $user->id)->where('id', $id)->first(); 
        if($data){
            
            $this->validate($request, [ 
                'is_seen'       => 'required'
            ], 
                [
                    'is_seen.required'  => 'Please provide value 1 or 0', 
                ]
            );

            $data->is_seen = $request->input('is_seen');
            $data->save(); 

            return response()->json([
                'message'       =>  'Status has been updated.', 
                'status_code' => 200
            ], 200);

        }else{
            return response()->json([
                'message'       =>  'Invalid notification', 
                'status_code' => 403
            ], 403);
        }

    }

    function test(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        
        $this->validate($request, [ 
            'title'             => 'required|max:255',
            'description'       => 'required|max:255',
            'image'             => 'required|max:255',
            'way'               => 'required|max:255', 
            'type'              => 'required|max:255'
        ]);

        if(in_array($request->input('way'), ['email', 'phone', 'firebase', 'sms', 'telegram', 'messenger'])){
            if(in_array($request->input('type'), ['Pending', 'Repairing', 'Fixed', 'Consulting', 'Declined', 'Comment', 'Reward'])){
                
                $metaData = [
                    'way'=>$request->input('way'), 
                    'title'=>$request->input('title'), 
                    'description'=>$request->input('description'), 
                    'type'=>$request->input('type'), 
                    'image'=>$request->input('image')
                ]; 

                if($request->input('action')){
                    $metaData['action'] = $request->input('action'); 
                    if($request->input('action_id')){
                        $metaData['action_id'] = $request->input('action_id'); 
                    }
                }

                $notify = Notify::send($user->id, $metaData);
               
                if($notify['status'] == 'success'){
                    return response()->json([
                            'message'       =>  'Message has been sent.', 
                            'status_code' => 200
                    ], 200);

                }else{
                    return response()->json([
                            'message'       =>  $notify['message'], 
                            'status_code' => 403
                    ], 403);

                }
            }else{
                return response()->json([
                    'message'       =>  'Invalid type', 
                    'status_code' => 403
                ], 403);
            }    
        }else{
            return response()->json([
                    'message'       =>  'Invalid way', 
                    'status_code' => 403
            ], 403);
        }      
            
    }

    function list(){
        $user = JWTAuth::parseToken()->authenticate();

        $data = UserNotification::select('id', 'title', 'description', 'type', 'image', 'action', 'action_id', 'is_seen', 'seen_at', 'created_at')->where(['user_id'=> $user->id, 'way'=>'firebase']);  
        $data = $data->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        $notifications = UserNotification::orderBy('id', 'desc')->where('user_id', $user->id)->limit(100)->get(); 
        $nOfUnreads = 0; 
        foreach($notifications as $row){
            if($row->is_seen == 0){
                $nOfUnreads++; 
            }
        }
        return response()->json(['notifications'=>$data, 'n_of_unreads'=>$nOfUnreads], 200);
    }


    
}
