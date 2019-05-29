<?php

namespace App\Api\V1\Controllers\Client\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Api\V1\Controllers\Client\Report\Controller as ReportController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Model\Pothole\Report as Report;
use App\Model\Pothole\Comment as Comment;
use App\Model\Pothole\File as File;

use App\MPWT\Notification as Notify;




class CommentController extends ReportController
{
    use Helpers;

    function addComemnt(Request $request, $reportId){
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [ 
            'comment'              => 'required', 
        ] );

        $report = Report::find($reportId);  
        if($report){
            
            $data = New Comment; 
            $data->report_id = $reportId; 
            $data->comment = $request->input('comment'); 
            $data->creator_id = $user->id; 
            $data->save();

            //Finding image of the report; 
            $file = File::select('id', 'uri', 'report_id')->where('report_id', $reportId)->first();
            $image = ''; 
            if($file){
                $image = $file->uri; 
            }


            //Check if having other users commented on this report
            $comments = Comment::select('creator_id')->distinct()->where('report_id', $reportId)->where('creator_id', '<>', $user->id)->get(); 
            if(count($comments) > 0){
                
                //Notification
                $metaData = [
                        'way'           =>  'firebase', 
                        'title'         =>  'New Comment From '.$user->name, 
                        'description'   =>   $data->comment, 
                        'type'          =>  'Comment', 
                        'image'         =>  $image, 
                        'action'        =>  'feeddetail', 
                        'action_id'     =>  $reportId
                ]; 
                foreach($comments as $comment){
                    $notify = Notify::send($comment->creator_id, $metaData);
                }
            }else{
                // this is first comment. Need to notifiy owner. 
                if($report->ru->user_id != $user->id){
                    $metaData = [
                            'way'           =>  'firebase', 
                            'title'         =>   $user->name.' commented on your report', 
                            'description'   =>   $data->comment, 
                            'type'          =>  'Comment', 
                            'image'         =>  $image, 
                            'action'        =>  'feeddetail', 
                            'action_id'     =>  $reportId
                    ];
                    $notify = Notify::send($report->ru->user_id, $metaData); 
                }
            }

            return $this->view($reportId);

        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid report']]
            ], 403);
        }
    }

    function updateComemnt(Request $request, $reportId, $commentId){
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [ 
            'comment'              => 'required', 
        ] );

        $report = Report::find($reportId);  
        if($report){
            $data = $report->comments()->find($commentId); 
            if($data){
                $data->comment = $request->input('comment'); 
                $data->updater_id = $user->id; 
                $data->save();
                
               return $this->view($reportId);
            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['invalid comment']]
                ], 403);
            }

        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['invalid report']]
            ], 403);
        }
    }

    function removeComemnt(Request $request, $reportId, $commentId){
        $user = JWTAuth::parseToken()->authenticate();

        $report = Report::find($reportId);  
        if($report){
            $data = $report->comments()->find($commentId); 
            if($data){
               
                $data->delete();
                
               return $this->view($reportId);

            }else{
                return response()->json(['status'=>'error', 'message'=>'Invalid comment'], 403);
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['invalid comment']]
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
