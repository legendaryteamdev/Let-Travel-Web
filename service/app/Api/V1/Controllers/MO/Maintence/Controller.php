<?php

namespace App\Api\V1\Controllers\MO\Maintence;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Api\V1\Controllers\ApiController;
use App\Model\Setting\Maintence\Main as Model;

use Dingo\Api\Routing\Helpers;

class Controller extends ApiController
{
    use Helpers;
    function list(){
        

        $data = Model::select('*')->with(['group:id,en_name,kh_name', 'type:id,en_name,kh_name', 'subtype:id,en_name,kh_name', 'unit:id,en_name,kh_name']);
        
         
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('kh_name', 'like', '%'.$key.'%')->orWhere('en_name', 'like', '%'.$key.'%');
            });
        }
        $data= $data->orderBy('code', 'asc')->paginate(intval(isset($_GET['limit'])?$_GET['limit']:10));
        return response()->json($data, 200);
    }

    
     
}
