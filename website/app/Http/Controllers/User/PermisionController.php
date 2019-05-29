<?php

namespace App\Http\Controllers\CP\User;

use Auth;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Model\User\Category as Model;
use App\Model\User\Permision;

class PermisionController extends Controller
{
    protected $route;
    public function __construct(){
        $this->route = "cp.user.permision";
    }
   

    public function index(){
        $data = Model::get();
        return view($this->route.'.index', ['route'=>$this->route, 'data'=>$data]);
    }
    public function permisions($id){
        $data = Model::find($id);
        return view($this->route.'.permisions', ['route'=>$this->route, 'data'=>$data]);
    }
    public function users(){
        $id = $_GET['id'];
        $data = Permision::find($id)->users;
        return view($this->route.'.users', ['route'=>$this->route, 'data'=>$data]);
    }
}

