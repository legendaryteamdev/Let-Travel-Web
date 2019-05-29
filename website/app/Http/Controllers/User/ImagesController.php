<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
 use Hash;
 use Auth;
 use Session ;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CamCyber\FileUploadController as FileUpload;

use App\Model\Image\Images as Model;


class ImagesController extends Controller
{
    
    function __construct (){
       
    }

   
    public function listData(){
        $data = Model::get();
        if(!empty($data)){
            return view('user.image.list', ['data'=>$data]);
        }else{
            return response(view('errors.404'), 404);
        }
    }
     public function showCreateForm(){
        return view('user.image.createForm');
    }
    public function store(Request $request) {
        $data = array();
        Session::flash('invalidData', $data );
        Validator::make(
                      $request->all(), 
                [
                    
                ], 

                        [
                           
                        ])->validate();
        
        $image = FileUpload::uploadFile($request, 'image', 'uploads/image/');
        if($image != ""){
            $data['image'] = $image; 
        }else{
            $data['image'] = "" ;
        }
    $id=Model::insertGetId($data);
        Session::flash('msg', 'Data has been Created!');
    return redirect(route('user.images.list'));
    }
  
    public function destroy($id){
        //Model::where('id', $id)->update(['deleter_id' => Auth::guard('user')->id()]);
        Model::where('id', $id)->delete();
        Session::flash('msg', 'Data has been delete!' );
        return response()->json([
            'status' => 'success',
            'msg' => 'User has been deleted'
        ]);
    }



   
    
}
