<?php

namespace App\Api\V1\Controllers\CP\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Road\Part as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class PartController extends ApiController
{
    use Helpers;
    function list($roadId=0){
        $data       =   Main::select('id', 'object_id', 'type_id', 'length', 'start', 'end')->where('road_id', $roadId)
                            ->with([ 
                                'type:id,name',
                                'pks'=>function($query){
                                    $query->select('pk_id', 'part_id')->distinct()
                                    ->with(['pk:id,code']);
                                }
                            ])
                            ->withCount([]); 

        $key        =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $data = $data->where(function($query) use ($key){
                $query->where('object_id', 'like', '%'.$key.'%');
            });
            
        }

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:100); 
        $data= $data->orderBy('id', 'asc')->paginate($limit);

        return response()->json($data, 200);
    }

  
}
