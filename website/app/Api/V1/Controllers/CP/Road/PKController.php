<?php

namespace App\Api\V1\Controllers\CP\Road;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\CamCyber\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\Road\PK as Main;
use Dingo\Api\Routing\Helpers;
use JWTAuth;


class PKController extends ApiController
{
    use Helpers;
    function list($roadId=0){
        $data       =   Main::select('id', 'code')->where('road_id', $roadId)
                            ->with([
                                'points'=>function($query){
                                    $query->select('id', 'pk_id', 'meter')->withCount(['potholes as n_of_potholes'])->orderBy('meter', 'ASC'); 
                                }, 
                                'parts'=>function($query){
                                    $query->select('pk_id', 'part_id')->distinct()
                                    ->with(['part:id,object_id']);
                                }
                            ])
                            ->withCount([
                                'points as n_of_points', 
                                'potholes as n_of_potholes'
                        ]); 

        $key        =   isset($_GET['key'])?$_GET['key']:"";
        if( $key != "" ){
            $key = str_replace("PK", "", $key); 
            $key = str_replace("pk", "", $key); 
            $key = str_replace(" ", "", $key); 
            $key = $data->where(function($query) use ($key){
                $query->where('code', 'like', '%'.$key.'%');
            });
            
        }

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:100); 
        $data= $data->orderBy('code', 'asc')->paginate($limit);

        return response()->json($data, 200);
    }

  
}
