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
use App\Model\User\Category;
use App\Model\Setup\Role as Role;

class UsersController extends Controller
{
    protected $route;
    public function __construct(){
        $this->route = "cp.user.user";
    }
    function validObj($id=0){
        $data = Model::find($id);
        if(empty($data)){
           echo "Invalide Object"; die;
        }
    }

    public function index(){
        
        $data = Model::where('visible', 1)->get();
        if(!empty($data)){
            return view($this->route.'.index', ['route'=>$this->route, 'data'=>$data]);
        }else{
            return view('errors.404');
        }
    }
   
    public function showCreateForm(){
        $positions = Position::get();
        return view($this->route.'.createForm', ['route'=>$this->route, 'positions'=>$positions]);
    }
    public function store(Request $request) {
        $position_id = $request->input('position_id');
        $status = 0;
        $is_ip_validated = 1;
        if($position_id == 1){
            $status = 1;
            $is_ip_validated = 0;
        }
        $data = array(
                    'kh_name' =>   $request->input('kh_name'),
                    'en_name' =>   $request->input('en_name'), 
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'position_id' =>  $request->input('position_id'),
                    'telegram_chat_id' =>  $request->input('telegram_chat_id'),
                    'status' =>  $status,
                    'is_ip_validated' =>  $is_ip_validated
                );
        Session::flash('invalidData', $data );
        Validator::make(
        	            $request->all(), 
			        	[
						    'kh_name' => 'required',
                            'en_name' => 'required',
                            
						    'phone' => [
							    			'required',
								        	Rule::unique('users')
								        ],
						    'email' => [
						    				'required',
                                            'email',
							        		Rule::unique('users')
							        	],
							'password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:password',
                            'picture' => [
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->width(200)->height(165),
                            ],
						], 

                        [
                            
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'picture.dimensions' => 'Please provide valide image dimensions 200x165.',
                        ])->validate();
        
        
        $picture = FileUpload::uploadFile($request, 'picture', 'uploads/user');
        if($picture != ""){
            $data['picture'] = $picture; 
        }
		$id=Model::insertGetId($data);
        Session::flash('msg', 'Data has been Created!');
		return redirect(route($this->route.'.edit', $id));
    }

    public function showEditForm($id = 0){
        $this->validObj($id);
        $data = Model::find($id);
        $positions = Position::get();
        return view($this->route.'.editForm', ['route'=>$this->route, 'id'=>$id, 'data'=>$data, 'positions'=>$positions]);
    }

    public function update(Request $request){
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
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'position_id' =>  $request->input('position_id'),
                    'status' =>  $request->input('status') ,
                    'telegram_chat_id' =>  $request->input('telegram_chat_id'),  
                    'is_ip_validated' =>  $request->input('is_ip_validated') 
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

    public function updatePassword(Request $request){
        $data = array(
                    'password' => bcrypt($request->input('password'))
                );
        $id = $request->input('id');
         Model::where('id', $id)->update($data);
        return response()->json([
            'status' => 'success',
            'msg' => 'Password has been updated.'
        ]);
    }

    function updateStatus(Request $request){
      $id   = $request->input('id');
      $data = array('status' => $request->input('status'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User status has been updated.'
      ]);
    }

    function updateAgentcy(Request $request){
      $id   = $request->input('id');
      $data = array('agentcy' => $request->input('active'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User agentcy has been updated.'
      ]);
    }

    function updateValidateIP(Request $request){
      $id   = $request->input('id');
      $data = array('is_ip_validated' => $request->input('active'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User IP validation has been updated.'
      ]);
    }
  
    public function destroy($id){
        Model::where('id', $id)->update(['deleter_id' => Auth::id()]);
        Model::where('id', $id)->delete();
        Session::flash('msg', 'Data has been delete!' );
        return response()->json([
            'status' => 'success',
            'msg' => 'User has been deleted'
        ]);
    }

    public function logs($id=0){
        $this->validObj($id);
        
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

    public function systemPermision($id=0){
        $categories = Category::get();
        $data = Model::find($id)->userPermisions;
        return view($this->route.'.systemPermision', ['route'=>$this->route, 'id'=>$id, 'data'=>$data, 'categories'=>$categories]);
    }
    // public function checkPermisions($id=0){
    //     $user_id        = $_GET['user_id'];
    //     $permision_id   = $_GET['permision_id'];
    //     $now            = date('Y-m-d H:i:s');
    //     $assigner_id    = Auth::id();

    //     $user = Model::find($user_id);
    //     $dataPermision = $user->userPermisions()->select('permision_id')->get(); 

    //     $is_permision_existed = 0;
    //     foreach($dataPermision as $row){
    //         if($row->permision_id == $permision_id){
    //             $is_permision_existed = 1;
    //         }
    //     }
       
    //     if($is_permision_existed == 1){
    //         $user->userPermisions()->where('permision_id', $permision_id)->delete();
    //         return response()->json([
    //               'status' => 'success',
    //               'msg' => 'Permision has been removed.'
    //         ]);
    //     }else{
    //         $data_permision=array(
    //             'user_id' => $user_id,
    //             'permision_id' => $permision_id,
    //             'creator_id' => $assigner_id, 
    //             'updater_id' => $assigner_id,
    //             'created_at' => $now, 
    //             'updated_at' => $now
    //             );
    //         $user->userPermisions()->insert($data_permision);
    //          return response()->json([
    //               'status' => 'success',
    //               'msg' => 'Permision has been added.'
    //           ]);
    //     }
    //}

}
