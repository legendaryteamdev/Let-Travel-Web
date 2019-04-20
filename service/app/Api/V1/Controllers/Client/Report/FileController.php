<?php

namespace App\Api\V1\Controllers\Client\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Model\Pothole\Report as Report;
use App\Model\Pothole\Comment as Comment;


class FileController extends ApiController
{
    use Helpers;

    function addFiles(Request $request, $reportId){
        $user = JWTAuth::parseToken()->authenticate();
        //$files = json_decode($request->input('files')); 

        $report = Report::find($reportId);  
        if($report){

            //Get Files from clients as Json and Image 64 Base
            $files =  json_decode($request->input('files')); 

            //print_r($files); die; 
            if(count($files)>0){
                foreach($files as $file){
                    $report->files()->insert([
                        'report_id'=>$report->id, 
                        'lat'=>$file->lat, 
                        'lng'=>$file->lng, 
                        'uri'=>FileUpload::forwardFile($file->img)
                    ]);
                }
                
                //================================>> Delete last 4th file. 
                $files = File::where('report_id', $reportId)->orderBy('id', 'DESC')->get(); 
                if(count($files)>3){
                    $i = 0;
                    foreach($files as $file){
                        $i++;
                        if($i > 3){
                            $file->delete(); 
                        }
                    }
                }

                return response()->json([
                    'status_code'   =>  200,
                    'message'       =>  "Files have been added."
                ], 200);

            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['pothole could not be created.']]
                ], 403);
            }
        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid report']]
            ], 403);
        }
    }

    function removeFile($reportId = 0, $fileId = 0){
        $report = Report::find($reportId);  
        if($report){
            $file = $report->files()->find($fileId); 
            if($file){
                $file->delete();
                return response()->json([
                    'status_code'   =>  200,
                    'errors'        =>  ['message'  =>  ['file has been removed']]
                ], 200);
            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['invalid file']]
                ], 403);
            }
            
        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid report']]
            ], 403);
        }
    }

  
    
}
