<?php

namespace App\Http\Controllers\CP\Auth;

use Auth;
use Session ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\CamCyber\AgentController as Agent;
use App\Http\Controllers\CamCyber\IpAddressController as IpAddress;
use App\Model\User\User;
use App\Model\User\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Model\User\Code;

use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'cp/payment';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('guest:user,cp.profile.edit', ['except' => 'logout']);
    }

    function showLoginForm(){

        return view('cp.auth.login');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password'); 
        $credentials['status'] = 1; 
        return $credentials;
    }

    //Create Logs
    protected function authenticated(Request $request, $user){
      if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))){
            $user = User::select('*')->where('email',$request->email)->first();
            //Log Information
            $agent      = new Agent;
            $info       = $agent::showInfo();
            $ipAddress  = new IpAddress;
            $ip         = $ipAddress::getIP(); 
            //print_r($info);die;
            //Save Logs
            $log = new Log;
            $log->user_id   = $user->id;
            $log->ip        = $ip;
            $log->os        = $info['os'];
            $log->broswer   = $info['browser'];
            $log->version   = $info['version'];
            $log->save();

            
            //Check if this is new browser never used in 30 days
            //$check = Log::select('*')->where(['user_id'=>$user->id, 'ip'=>$log->ip, 'os'=>$log->os, 'broswer'=>$log->tool, 'version'=>$log->version]); 
            //echo $check;die;
            //$check = $check->where('created_at', '>=', Carbon::now()->subDays(30).' 00:00:00')->get();

          //   if(count($check) == 0){
              
          //     //  if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                  
          //     //     $code = new Code; 
          //     //     $code->user_id = $user->id; 
          //     //     $code->code = uniqid();
          //     //     $code->type = 'LOGIN DEVICE';
          //     //     $code->is_verified = 0; 
          //     //     $code->save(); 

          //     //     $response = Telegram::sendMessage([
          //     //       'chat_id' => $user->telegram_chat_id, 
          //     //       'text' => '<b>Security Allert</b>: We have found that, you recently have logged to system with new device. Please use this code: <b>'.$code->code.'</b> to verify.Thanks',
          //     //       'parse_mode' => 'HTML'
          //     //     ]);
                  
          //     //     $this->guard()->logout();
          //     //     return redirect('cp/auth/verify-device');
                  
          //     // }
          // }
          
          // if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
          //       $response = Telegram::sendMessage([
          //         'chat_id' => $user->telegram_chat_id, 
          //         'text' => '<b>New Logged In Information</b>: You have logged to system with following information,
          //                   IP Address: <code>'.$log->ip.'</code>,
          //                   Operating System: <code>'.$log->os.'</code>,
          //                   Tool: <code>'.$log->tool.'</code>,
          //                   Version: <code>'.$log->version.'</code>,
          //                   Date and Time: '.Carbon::now().'
          //                   Please review it something went wrong. Thanks
          //                   ',
          //         'parse_mode' => 'HTML'
          //       ]);

          //   }
        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }
   
    public function logout(Request $request){
         $user = Auth::user('user');
            // if($user->telegram_chat_id != '' && $user->telegram_chat_id != null){
                
            //     $response = Telegram::sendMessage([
            //       'chat_id' => $user->telegram_chat_id, 
            //       'text' => '<b>System Allert</b>:<b> Your System is being logout.</b> Thanks!',
            //       'parse_mode' => 'HTML'
            //     ]);

            // }
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('cp.auth.login');
    }


   
}
