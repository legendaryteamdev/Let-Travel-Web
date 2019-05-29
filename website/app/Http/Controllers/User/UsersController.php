<?php

namespace App\Http\Controllers\User;

use Auth;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CamCyber\FileUploadController as FileUpload;

use App\Model\User\Users as Model;

class UsersController extends Controller
{
    public function listData(){
        $data = Model::where('visible', 1)->get();
        if(!empty($data)){
            return view('user.user.list', ['data'=>$data]);
        }else{
            return response(view('errors.404'), 404);
        }
    }
   
    public function showCreateForm(){
        return view('user.user.createForm');
    }
    public function store(Request $request) {
        $data = array(
                    'name' =>   $request->input('name'), 
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'position_id' =>  $request->input('position_id'),
                    'active' =>  $request->input('active') 
                );
        Session::flash('invalidData', $data );
        Validator::make(
        	            $request->all(), 
			        	[
						    'name' => 'required|min:6|max:18',
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
                            'image' => [
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->minWidth(100)->minHeight(100)->maxWidth(500)->maxHeight(500),
                            ],
						], 

                        [
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'image.dimensions' => 'Please provide valide image with height between 100-500px and width between 100-500px.',
                        ])->validate();
        
        
        $image = FileUpload::uploadFile($request, 'image', 'uploads/user/');
        if($image != ""){
            $data['image'] = $image; 
        }else{
            $data['image'] = "public/user/img/avatar.png" ;
        }
		$id=Model::insertGetId($data);
        Session::flash('msg', 'Data has been Created!');
		return redirect(route('user.user.edit', $id));
    }

    public function showEditForm($id = 0){
        $data = Model::find($id);
        if(!empty($data)){
            return view('user.user.editForm', ['data'=>$data]);
        }else{
            return response(view('errors.404'), 404);
        }
    }

    public function update(Request $request){
        $id = $request->input('id');
        Validator::make(
        				$request->all(), 
			        	[
						    'name' => 'required|min:2|max:18',
						    'phone' => [
							    			'required',
								        	Rule::unique('users')->ignore($id)
								        ],
						    'email' => [
						    				'required',
                                            'email',
							        		Rule::unique('users')->ignore($id)
							        	],
                            'image' => [
                                            'sometimes',
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->minWidth(100)->minHeight(100)->maxWidth(500)->maxHeight(500),
                            ],
						],
                        [
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'image.dimensions' => 'Please provide valide image with height between 100-500px and width between 100-500px.',
                        ])->validate();

		
		$data = array(
                    'name' =>   $request->input('name'), 
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'position_id' =>  $request->input('position_id'),
                    'active' =>  $request->input('active') 
                );
        
        $image = FileUpload::uploadFile($request, 'image', 'uploads/user/');
        if($image != ""){
            $data['image'] = $image; 
        }
		
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
      $data = array('active' => $request->input('active'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User status has been updated.'
      ]);
    }
  
    public function destroy($id){
        Model::where('id', $id)->update(['deleter_id' => Auth::guard('user')->id()]);
        Model::where('id', $id)->delete();
        Session::flash('msg', 'Data has been delete!' );
        return response()->json([
            'status' => 'success',
            'msg' => 'User has been deleted'
        ]);
    }
}
