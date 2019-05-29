<?php

namespace App\Http\Controllers\CP\Image;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CamCyber\FileUploadController as FileUpload;
use App\Http\Controllers\CamCyber\FunctionController;

use App\Model\Image\Main as Model;


class ImagesController extends Controller
{
    
    function __construct (){
       $this->route = "cp.image";
    }

   
    public function index($page = ""){ 
      $data = Model::select('*');
        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        $from=isset($_GET['from'])?$_GET['from']:"";
        $till=isset($_GET['till'])?$_GET['till']:"";
        $appends=array('limit'=>$limit);
        if( $key != "" ){
            $data = $data->where('name', 'like', '%'.$key.'%');
            $appends['key'] = $key;
        }
        if(FunctionController::isValidDate($from)){
            if(FunctionController::isValidDate($till)){
                $appends['from'] = $from;
                $appends['till'] = $till;

                $from .=" 00:00:00";
                $till .=" 23:59:59";

                $data = $data->whereBetween('created_at', [$from, $till]);
            }
        }
        $data= $data->orderBy('id', 'DESC')->paginate($limit);
        return view($this->route.'.index', ['route'=>$this->route, 'data'=>$data,'appends'=>$appends]);
    }

    public function create(){
        return view($this->route.'.create' , ['route'=>$this->route]);
    }

    public function store(Request $request) {
        $user_id    = Auth::id();
        $now        = date('Y-m-d H:i:s');
        $data = array( 
                    'title' =>   $request->input('title'), 
                    'created_at' => $now
                );
        $validate['image'] = array( 'sometimes',
                                  'required',
                                );
      
        Validator::make($request->all(), $validate)->validate();
  
        $image = FileUpload::uploadFile($request, 'image', 'uploads/image');
        if($image != ""){
            $data['img_url'] = $image; 
        }
        
        $id=Model::insertGetId($data);
        Session::flash('msg', 'Data has been Created!');
    return redirect(route($this->route.'.edit', $id));
    }

    public function showEditForm($id = 0){   
      $data = Model::where('id', $id)->first();
      if(!empty($data)){
        return view('cp.image.edit', ['route'=>$this->route,'data'=>$data]);
      }else{
        return response(view('errors.404'), 404);
      }
    }

    public function update(Request $request){   
      $id = $request->input('id');
      $image = "";
     
      $data = array( 
                    'title' =>   $request->input('title')
                );
      $validate['image'] = array( 'sometimes',
                                  'required',
                                );
      
      Validator::make($request->all(), $validate)->validate();
  
      $image = FileUpload::uploadFile($request, 'image', 'uploads/image');
      if($image != ""){
          $data['img_url'] = $image; 
      }

      Model::where('id', $id)->update($data);
      Session::flash('msg', 'Data has been updated!' );
      return redirect()->back(); 
    }

    function updateStatus(Request $request){
      $id   = $request->input('id');
      $data = array('published' => $request->input('published'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'Images status has been updated.'
      ]);
    }
     public function trash($id){
        //Model::where('id', $id)->update(['deleter_id' => Auth::id()]);
        Model::find($id)->delete();
        Session::flash('msg', 'Data has been delete!' );
        return response()->json([
            'status' => 'success',
            'msg' => 'Data has been deleted'
        ]);
    }
   
}
