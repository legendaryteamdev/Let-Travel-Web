<?php

namespace App\Api\V1\Controllers\MT\Maintence;

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
        

        $data = Model::select('*')->with(['group:id,en_name,kh_name', 'type:id,en_name,kh_name', 'subtype:id,en_name,kh_name', 'unit:id,en_name,kh_name'])
        ->withCount(['potholes as n_of_potholes']);
         
        $key       =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('kh_name', 'like', '%'.$key.'%')->orWhere('en_name', 'like', '%'.$key.'%');
            });
        }
        
        $from=isset($_GET['from'])?$_GET['from']:"";
        $to=isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){

                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $data= $data->orderBy('code', 'asc')->paginate($limit);
        return response()->json($data, 200);
    }

    
     
}
