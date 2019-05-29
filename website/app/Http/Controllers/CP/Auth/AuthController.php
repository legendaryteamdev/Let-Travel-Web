<?php

namespace App\Http\Controllers\CP;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CamCyber\AgentController as Agent;
use App\Http\Controllers\CamCyber\IpAddressController as IpAddress;

use App\Model\User\Log;

use Telegram\Bot\Laravel\Facades\Telegram;
use Hash;
use Auth;
use Session ;


class AuthController extends Controller {
    
   
    public function login () {
        if (!Auth::guard('user')->check()) 
            return view('cp/auth.login');
        else 
            return redirect()->route('cp.user.profile');
    }   

    protected function authenticate(Request $request) {

        $password = $request->input('password');
        $username = $request->input('username');
        $remember = 0;
        if($request->input('remember') == 'on'){
            $remember = 1;
        }
        
        $credentials['password']    = $password;
        $credentials['active']      = 1;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $username;
        }else if(preg_match("/(^[00-9].{8}$)|(^[00-9].{9}$)/",$username)){
            $credentials['phone'] = $username;
        }else{
            Session::flash ('flashmessage', trans('Invalide Username')) ;
            return redirect()->route('cp.auth.login');
        }

        if (Auth::guard('user')->attempt($credentials, $remember)) {
            $agent      = new Agent;
            $info       = $agent::showInfo();
            $ipAddress  = new IpAddress;
            $ip         = $ipAddress::getIP(); 
            //Save Logs
            $log = new Log;
            $log->user_id   = Auth::user('user')->id;
            $log->ip        = $ip;
            $log->os        = $info['os'];
            $log->broswer   = $info['browser'];
            $log->version   = $info['version'];
            $log->save();

            $user = Auth::user('user');
            // if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
            //     $response = Telegram::sendMessage([
            //       'chat_id' => $user->telegram_chat_id, 
            //       'text' => '<b>System Allert</b>:<b> Your System has been logined successful.</b> Thanks!',
            //       'parse_mode' => 'HTML'
            //     ]);

            // }

            return redirect()->route('cp.profile');
        } else {
            Session::flash ('flashmessage', trans('Username Password Not Correct')) ;
            return redirect()->route('cp.auth.login');
        }
    }
    public function logout () {
        $user = Auth::user('user');
            // if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
            //     $response = Telegram::sendMessage([
            //       'chat_id' => $user->telegram_chat_id, 
            //       'text' => '<b>System Allert</b>:<b> Your System is being logout.</b> Thanks!',
            //       'parse_mode' => 'HTML'
            //     ]);

            // }
        Auth::guard('user')->logout() ;
        return redirect()->route('cp.auth.login');
    }

    public function reset(){
        return view('cp/auth.reset-password');
    }
    public function makeResetCode(Request $request){
        $username = $request->input('username');
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $username;
        }else{
            Session::flash ('flashmessage', trans('Invalide E-mail address')) ;
            return redirect()->route('cp.auth.reset-password');
        }
    }
    public function compareResetCode(){
        return view('cp/auth.login');
    }
    public function changePassword(){
        return view('cp/auth.login');
    }
    public function SubmitChangePassword(){
        return view('cp/auth.login');
    }

  
}