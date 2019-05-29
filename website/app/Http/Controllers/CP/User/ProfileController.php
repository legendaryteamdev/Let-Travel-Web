<?php

namespace App\Http\Controllers\CP\User;

use Auth;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CamCyber\FileUploadController as FileUpload;
use App\Http\Controllers\CamCyber\FunctionController;

use App\Model\User\User as Model;
use App\Model\User\Position;


class ProfileController extends Controller
{
    protected $route;
    public function __construct(){
        $this->route = "cp.user.profile";
    }
    public function edit(){  
        $user = Auth::user();
        //echo $user->picture; die;
        return view($this->route.'.editForm', ['route'=>$this->route, 'data'=>$user]);
        
    }
    public function update(Request $request) {
       $id = $request->input('id');
        Validator::make(
                        $request->all(), 
                        [
                            'kh_name' => 'required',
                            'en_name' => 'required',
                           
                            
                            'phone' => [
                                            'required',
                                            Rule::unique('users')->ignore($id)
                                        ],
                            'email' => [
                                            'required',
                                            'email',
                                            Rule::unique('users')->ignore($id)
                                        ],
                            'picture' => [
                                            'sometimes',
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->width(200)->height(165),
                            ],
                        ],
                        [
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'picture.dimensions' => 'Please provide valide image dimensions 200x165.',
                        ])->validate();

        
        $data = array(
                    'kh_name' =>   $request->input('kh_name'),
                    'en_name' =>   $request->input('en_name'), 
                    'description' =>  $request->input('description'),
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                );
        
        $picture = FileUpload::uploadFile($request, 'picture', 'uploads/user');
        if($picture != ""){
            $data['picture'] = $picture; 
        }
        //echo $picture; die;
        Model::where('id', $id)->update($data);
        Session::flash('msg', 'Data has been updated!' );
        return redirect()->back();
    }

    public function showEditPasswordFrom(){  
        $user = Auth::user();
        return view($this->route.'.editPasswordForm', ['route'=>$this->route, 'data'=>$user]);
        
    }
    public function changePassword (Request $request){
        $id =  Auth::user()->id;
        $old_password = $request->input('old_password');
        $current_password = Model::find($id)->password;
        // echo $old_password. '<br />';
        // echo $current_password. '<br />';die; 

        if (password_verify($old_password, $current_password)){ 

            Validator::make(
                        $request->all(), 
                        [
                            'new_password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:new_password',
                        ], 
                        [
                            'new_password.same' => 'Please confirm your password.',
                        ])->validate();
            Model::where('id', $id)->update(['password' => bcrypt($request->input('new_password'))]);
            Session::flash('msg', 'Password has been Reset!' );
            return redirect()->back();
        }else{
            echo 'Not Valide';
        }
       
        
    }
    public function logs(){
        $id =  Auth::user()->id;
        $dataLog = Model::find($id)->logs();

        $limit=intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $from=isset($_GET['from'])?$_GET['from']:"";
        $till=isset($_GET['till'])?$_GET['till']:"";

        if($limit <= 0 || $limit > 100){
            $limit = 10;
        }

        $appends=array('limit'=>$limit);
       
        if(FunctionController::isValidDate($from)){
            if(FunctionController::isValidDate($till)){
                $appends['from'] = $from;
                $appends['till'] = $till;

                $from .=" 00:00:00";
                $till .=" 23:59:59";

                $dataLog = $dataLog->whereBetween('created_at', [$from, $till]);
            }
        }
       
        $logs= $dataLog->orderBy('created_at', 'DESC')->paginate($limit);
        return view($this->route.'.logs', ['route'=>$this->route, 'id'=>$id, 'data'=>$logs, 'appends'=>$appends]);
    }
    
}
