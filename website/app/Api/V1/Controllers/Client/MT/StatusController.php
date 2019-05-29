<?php

namespace App\Api\V1\Controllers\Client\MT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\MPWT\FileUpload;

use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Report as Report;
use App\Model\Pothole\Status as Status;
use App\Model\Pothole\StatusFile as File;
use App\MPWT\Notification as Notify;
use App\Model\Setting\Status as StatusData;
use App\Model\Pothole\File as ReportFile;

class StatusController extends ApiController
{
    use Helpers;

    function create(Request $request, $potholeId){
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [ 
            'status_id'             => 'required|numeric|exists:status,id', 
            'maintence_code_id'     => 'sometimes|exists:maintence,id',
            'quantity'              => 'sometimes|numeric'
        ], [
            'status_id.required'         =>  'Please select any statuses.',
            'status_id.numeric'          =>  'Status must be a numberic value',
            'status_id.exists'          =>  'Please choose a valid status',

            'maintence_code_id.exists' => 'Invalid code', 

        ]);

        $pothole = Pothole::find($potholeId);  
        if($pothole){
            
            //Create Staus
            $status             = new Status; 
            $status->pothole_id = $potholeId; 
            $status->status_id  = $request->input('status_id'); 
            $status->comment    = $request->input('comment'); 
            $status->creator_id = $user->id; 
            $status->updater_id = $user->id; 
            $status->save();

            if($request->input('maintence_code_id')){
                $pothole->maintence_id = $request->input('maintence_code_id');
                if($request->input('quantity')){
                    $pothole->quantity    = $request->input('quantity'); 
                }
                $pothole->save();
            }

            $files =  json_decode($request->input('files')); 
            $this->upload($status->id, $files);

            //Send Notification To MO
            if($pothole->action){
                //Find image
                $file = ReportFile::select('id', 'uri', 'report_id')->whereHas('report', function($query) use ($pothole){
                    $query->where('pothole_id', $pothole->id); 
                })->first();
                $image = ''; 
                if($file){
                    $image = $file->uri; 
                }

                $statusData = StatusData::find($request->input('status_id'));
                $metaData = [
                    'way'           =>  'firebase', 
                    'title'         =>  'Update from MT!', 
                    'description'   =>  'From '.$user->name, 
                    'type'          =>      $statusData->name, 
                    'image'         =>   $image, 
                    'action'       =>   'potholedetail', 
                    'action_id'     =>    $pothole->id
                ];

                Notify::send($pothole->action->assigner->user_id, $metaData);
            }

            //Send Notification to Reporters
            if($request->input('status_id') == 4){ //Fixed
                $reports =Report::select('member_id', 'id')->distinct()->with(['ru:id,user_id', 'files:id,report_id,uri'])->where('pothole_id', $pothole->id)->get(); 
                
                //return $reports;
                if(count($reports) > 0){
                    foreach($reports as $report){
                        $metaData = [
                            'way'           =>  'firebase', 
                            'title'         =>  'Report Fixed', 
                            'description'   =>  'Your report has been fixed. Thanks for your cooperation.', 
                            'type'          =>  'Fixed', 
                            'image'         =>   $report->files[0]->uri, 
                            'action'       =>   'feeddetail', 
                            'action_id'     =>    $report->id
                        ];
                        Notify::send($report->ru->user_id, $metaData);
                    }
                }
            }
                


            return response()->json([
                'status'          =>  $status, 
                'status_code'   =>  200,
                'message'=>'stauts updated'
            ], 200);

        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid pothole']]
            ], 403);
        }
    }

    function addFiles(Request $request, $potholeId = 0, $statusId = 0){
        $user = JWTAuth::parseToken()->authenticate();
       
        //Check if report is valid
        $pothole = Pothole::find($potholeId);  
        if($pothole){
            //Check if status is valid
            $status = Status::find($statusId); 
            if($status){
                if($status->pothole_id == $potholeId){
                    $files =  json_decode($request->input('files')); 
                    $this->upload($statusId, $files);
                    return response()->json([
                        'status_code'   =>  200,
                        'errors'        =>  ['message'  =>  ['Files have been uploaded']]
                    ], 200);

                }else{
                    return response()->json([
                        'status_code'   =>  403,
                        'errors'        =>  ['message'  =>  ['this status record does not belong to the submmitted pothole']]
                    ], 403);
                }
                
            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['invalide status pothole']]
                ], 403);
            }
                
        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid pothole']]
            ], 403);
        }
    }

    function upload($statusId = 0, $files){

        //print_r($files); die; 
        if(count($files)>0){
            
            foreach($files as $file){
                $statusFile = new File(); 
                $statusFile->status_id = $statusId; 
                $statusFile->lat = $file->lat; 
                $statusFile->lng = $file->lng; 
                $statusFile->uri = FileUpload::forwardFile($file->img, "pothole/status"); 
                $statusFile->save(); 
            }
            
         
        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['pothole could not be created.']]
            ], 403);
        }
    }

    
}
