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
use App\Model\User\Code;
use Telegram\Bot\Laravel\Facades\Telegram;

use Carbon\Carbon;

class VerifyDeviceController extends Controller
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
    protected $redirectTo = 'cp/user/profile';
    
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password'); 
        $credentials['status'] = 1; 
        return $credentials;
    }

    function showVerifyForm(){

        return view('cp.auth.verify-device');
    }

     public function submitCode(Request $request) {
        
        $this->validate($request, [
            'code' => 'required|min:6',
        ]);
        
        $code = $request->input('code'); 
        

        $data = Code::where(['code'=>$code, 'type'=>'LOGIN DEVICE'])->orderBy('id', 'DESC')->first(); 
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
                    $code->verified_at = $now; 
                    $code->save();

                    //Log Information
                    $agent      = new Agent;
                    $info       = $agent::showInfo();
                    $ipAddress  = new IpAddress;
                    $ip         = $ipAddress::getIP(); 

                    //Save Logs
                    $log = new Log;
                    $log->user_id   = $user->id;
                    $log->ip        = $ip;
                    $log->os        = $info['os'];
                    $log->broswer   = $info['browser'];
                    $log->version   = $info['version'];
                    $log->save();
                    Auth::loginUsingId($user->id, true);
                    return redirect('cp/user/profile');
                    
                }else{
                    
                     Session::flash('msg', 'User Not Found!');
                     return view('cp.auth.verify-device');
                }
            }else{
                
                Session::flash('msg', 'Code Expired!');
                return view('cp.auth.verify-device');
            }
                
        }else{
           
            Session::flash('msg', 'Code Not Valid!');
            return view('cp.auth.verify-device');
        }
       
    }

}
