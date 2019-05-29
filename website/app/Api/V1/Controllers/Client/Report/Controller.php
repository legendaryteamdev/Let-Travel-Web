<?php

namespace App\Api\V1\Controllers\Client\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\MPWT\FileUpload;
use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use TelegramBot; 

use App\Model\Member\Main as RU;

use App\Model\Pothole\Main as Pothole;
use App\Model\Pothole\Status as PotholeStatus;
use App\Model\Pothole\Location as PotholeLocation;
use App\Model\Pothole\Report as Report;
use App\Model\Pothole\ReportLocation as ReportLocation;
use App\Model\Pothole\File as ReportFile;
use App\Model\Pothole\Comment as ReportComment;

use App\Model\Road\Point as PKPoint;
use App\Model\Authority\MO\Road as MORoad;

use App\Model\Authority\MO\Main as MO;
use App\Model\Authority\MT\Main as MT;

use App\Model\Location\Commune;
use App\Model\Location\Village;

use App\MPWT\LatLngUMTConvert;
use App\MPWT\RoadCare; 

use Grimzy\LaravelMysqlSpatial\Types\MultiPoint;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\MPWT\Notification as Notify;


class Controller extends ApiController
{
    use Helpers;

    function list(){

        //Fetch authenticated user information
        $user = JWTAuth::parseToken()->authenticate();

        $data = Report::select('id', 'pothole_id', 'description', 'lat', 'lng', 'member_id', 'commune_id', 'additional_location', 'is_posted', 'created_at')
        ->with([
            'ru:id,user_id',
            'ru.user:id,name,avatar,email,phone',
            'files:id,report_id,uri,lat,lng,is_accepted', 
            'comments'=>function($query){
                $query->select('id', 'report_id', 'creator_id', 'comment', 'created_at')
                ->with('commenter:id,name,avatar,email,phone')->orderBy('id', 'DESC')->get();
            }, 
            'pothole'=>function($query) use ($user){
                $query->select('id', 'created_at', 'point_id', 'code', 'maintence_id')
                ->with([
                     'comments'=>function($query){
                        $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                        ->with('commenter:id,name,avatar,email,phone')->orderBy('id', 'DESC')->get();
                    }, 

                    'location:id,pothole_id,village_id,commune_id,district_id,province_id,lat,lng', 
                    'location.village:id,name,code', 
                    'location.commune:id,name,code', 
                    'location.district:id,name,code', 
                    'location.province:id,name,code', 

                    // 'maintence'=>function($query) use ($user){
                    //     $lang = $user->lang; 
                    //     $query->select('id', 'group_id', 'type_id', 'subtype_id', 'unit_id', 'code', $lang.'_name as name', 'rate')
                    //     ->with([
                    //         'group'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'type'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'subtype'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'unit'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //     ]);
                    // },

                    'point:id,pk_id,meter', 
                    'point.pk:id,code,road_id',
                    'point.pk.road:id,name,start_point,end_point',

                    'statuses'=>function($query){
                        $query->select('id', 'pothole_id', 'status_id', 'mt_id', 'updater_id', 'comment', 'updated_at')
                        ->with([
                            'status:id,name', 
                            'updater:id,name,avatar,email,phone', 
                            'mt:id,user_id', 
                            'mt.user:id,name,avatar,email,phone'
                        ])
                        ->orderBy('id', 'DESC')->get(); 
                    }, 
                    'files:uri,lat,lng'
                   
                ]); 
            }, 
            'locations'=>function($query){
                $query->select('id', 'report_id', 'village_id', 'distance')
                ->with([
                    'village:id,name,code,commune_id', 
                    'village.commune:id,name,code,district_id',
                    'village.commune.district:id,name,code,province_id', 
                    'village.commune.district.province:id,name,code'
                ]); 
            }, 

           // 'commune:id,name,code,dis'
        ])->withCount('comments as num_of_comments'); 

        $limit      =   intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $from=isset($_GET['from'])?$_GET['from']:"";
        $to=isset($_GET['to'])?$_GET['to']:"";
        if(isValidDate($from)){
            if(isValidDate($to)){
               
                $from .=" 00:00:00";
                $to .=" 23:59:59";
                $data = $data->whereBetween('created_at', [$from, $to]);
            }
        }

        $key=isset($_GET['key'])?$_GET['key']:"";
        if($key != ""){
            $data = $data->where('description', 'LIKE', '%'.$key.'%'); 
        }

        $potholeId      =   intval(isset($_GET['potholeId'])?$_GET['potholeId']:0); 
        if($potholeId != 0){
            $data = $data->where('pothole_id', $potholeId); 
        }

        $data = $data->where('is_posted', 1); 

        $roles = $this->checkUserPosition($user->id); 

        if(in_array('mo', $roles)){
            $mo = MO::select('id')->with(['mts:id,mt_id,mo_id', 'mts.mt:id,province_id'])->where('user_id', $user->id)->first(); 
            
            $provinces = []; 
            foreach($mo->mts as $row){
                if($row->mt->province_id != null){
                    $provinces[] = $row->mt->province_id; 
                } 
            }
            $data = $data->where(function($query) use ($provinces){
                $query->whereHas('pothole', function($query) use ($provinces){
                    $query->whereHas('location', function($query) use ($provinces){
                       $query->whereIn('province_id', $provinces);
                    });
                })->orWhereHas('ru', function($query) use ($mo) {
                    $query->whereHas('user', function($query) use ($mo) {
                        $query->where('id', $mo->user_id); 
                    });
                });
            }); 

        }else if(in_array('mt', $roles)){
            $mt = MT::where('user_id', $user->id)->first(); 
            $data = $data->where(function($query) use ($mt){
                $query->whereHas('pothole', function($query) use ($mt){
                    $query->whereHas('action', function($query) use ($mt){
                        $query->where('mt_id', $mt->id); 
                    }); 
                })->orWhereHas('ru', function($query) use ($mt) {
                    $query->whereHas('user', function($query) use ($mt) {
                        $query->where('id', $mt->user_id); 
                    });
                });
            });

        }else if(in_array('ru', $roles)){
            $data = $data->whereHas('ru', function($query) use ($user) {
                $query->whereHas('user', function($query) use ($user) {
                    $query->where('id', $user->id); 
                });
            }); 
        }

        
       
        $data = $data->orderBy('id', 'desc')->paginate($limit);
        
        return response()->json($data, 200);
    }

    function view($id = 0){
        //Fetch authenticated user information
        $user = JWTAuth::parseToken()->authenticate();

        $data = Report::select('id', 'pothole_id', 'description', 'lat', 'lng', 'member_id', 'commune_id', 'created_at', 'is_posted','additional_location')
        ->with([
            'ru:id,user_id',
            'ru.user:id,name,avatar,email,phone',
            'files:id,report_id,uri,lat,lng,is_accepted', 
            'comments'=>function($query){
                $query->select('id', 'report_id', 'creator_id', 'comment', 'created_at')
                ->with('commenter:id,name,avatar,email,phone')->orderBy('id', 'DESC')->get();
            }, 
            'pothole'=>function($query) use ($user){
                $query->select('id', 'created_at', 'point_id', 'code', 'maintence_id')
                ->with([
                     'comments'=>function($query){
                        $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                        ->with('commenter:id,name,avatar,email,phone')->orderBy('id', 'DESC')->get();
                    }, 

                    'location:id,pothole_id,village_id,commune_id,district_id,province_id,lat,lng', 
                    'location.village:id,name,code', 
                    'location.commune:id,name,code', 
                    'location.district:id,name,code', 
                    'location.province:id,name,code', 

                    // 'maintence'=>function($query) use ($user){
                    //     $lang = $user->lang; 
                    //     $query->select('id', 'group_id', 'type_id', 'subtype_id', 'unit_id', 'code', $lang.'_name as name', 'rate')
                    //     ->with([
                    //         'group'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'type'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'subtype'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //         'unit'=>function($query) use ($lang){
                    //             $query->select('id', $lang.'_name as name');
                    //         },
                    //     ]);
                    // },

                    'point:id,pk_id,meter', 
                    'point.pk:id,code,road_id',
                    'point.pk.road:id,name,start_point,end_point',

                    'statuses'=>function($query){
                        $query->select('id', 'pothole_id', 'status_id', 'mt_id', 'updater_id', 'comment', 'updated_at')
                        ->with([
                            'status:id,name', 
                            'updater:id,name,avatar,email,phone', 
                            'mt:id,user_id', 
                            'mt.user:id,name,avatar,email,phone'
                        ])
                        ->orderBy('id', 'DESC')->get(); 
                    }, 
                    'files:uri,lat,lng'
                   
                ]); 
            }, 
            'locations'=>function($query){
                $query->select('id', 'report_id', 'village_id', 'distance')
                ->with([
                    'village:id,name,code,commune_id', 
                    'village.commune:id,name,code,district_id',
                    'village.commune.district:id,name,code,province_id', 
                    'village.commune.district.province:id,name,code'
                ]); 
            }, 

           // 'commune:id,name,code,dis'
        ])->withCount('comments as num_of_comments'); 

       
        $data = $data->where('is_posted', 1)
        // ->whereHas('ru', function($query) use ($user) {
        //     $query->whereHas('user', function($query) use ($user) {
        //         $query->where('id', $user->id); 
        //     });
        // })
        ->find($id);

        if($data){
            $data['status_code'] = 200; 
            return response()->json($data, 200);
        }else{
           return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['no data found or invalid access']]
            ], 403);
        }
    }
    
    function create(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
       

        if($request->input('report_id') && $request->input('report_id') != 0){
            return $this->publishReport($request->input('report_id')); 
        }

        //Repot Validation
        $this->validate($request, [ 
            'description'       => 'required|max:255', 
            'files'             => 'required|json',
        ], 
            [
                'description.required'  => 'សូមបញ្ចូលការពិពណ៌នា', 
                'description.max'       => 'អត្ថបទអតិបរមាគឺ 255 តួអក្សរ'
            ]
        );

        //Check if having any file submitted.
        $files =  json_decode($request->input('files')); 
        if(count($files) > 0){
            $lat = 0; 
            $lng = 0;

            if($files->file1){
                if($files->file1->lat && $files->file1->lng){
                    $lat = $files->file1->lat; 
                    $lng = $files->file1->lng; 
                }
            }
            if($lat == 0 && $lng == 0){
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['Invalid lat & lng in file']]
                ], 403);
            }
            //Check if image are in the same location; 

            //Create Pothole
            $pothole = New Pothole; 
            $messages     = [];//for error message
            $isNewPothole = 0; 

            //========================================>> Check if having any potholes reported around this location
            $utm        = LatLngUMTConvert::ll2utm($lat, $lng); 
            $rRoad      = 100; 
            $location   = RoadCare::getLocation($lat, $lng);//Check if having correct location
            $road       = RoadCare::getRoad($lat, $lng); //Check if having nearest NR
           
           
            $existingPothole = Pothole::select('id', 'action_id', 'maintence_id', 'point_id', 'created_at')
            ->whereHas('reports', function($query) use ($utm, $rRoad){
                 $query->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$rRoad); 
            })
            ->whereDoesntHave('statuses', function($query){
                $query->where('status_id', 4); //Fixed
            })
            ->first();
            
            if($existingPothole){
                $pothole    = $existingPothole; 
            }else{
                        
                //Create new Pothole
                $pothole->creator_id    = $user->id; 
                if(isset($road['id'])){
                    $pothole->point_id      = $road['id']; 
                }
                $pothole->save(); 
                //Update code
                $pothole->code = $this->generatePotholeCode($pothole->id);
                $pothole->save(); 

                $isNewPothole = 1;

                //Create Pothole Location
                $potholeLocation = new PotholeLocation; 
                $potholeLocation->pothole_id    = $pothole->id; 

                if(isset($location['village'])){
                    $potholeLocation->village_id = $location['village']['id']; 
                }

                if(isset($location['commune'])){
                    $potholeLocation->commune_id    = $location['commune']['id']; 
                    $potholeLocation->district_id   = $location['commune']['district']['id']; 
                    $potholeLocation->province_id   = $location['commune']['district']['province']['id'];
                }
                $potholeLocation->save(); 

                //Create Status
                $status             = new PotholeStatus; 
                $status->pothole_id = $pothole->id; 
                $status->status_id  = 1; //Pending
                $status->comment    = $request->input('description'); 
                $status->creator_id = $user->id; 
                $status->updater_id = $user->id; 
                $status->save();

               
                   
            }

            //Unless pothole is valid, a report will be created.
            if($pothole){
            
                //Create report
                $report                 = New Report; 
                $report->pothole_id     = $pothole->id; 
                if(isset($location['commune']['id'])){
                    $report->commune_id     = $location['commune']['id'];
                }else{
                    $report->commune_id     = 928;
                }
                $report->description    = $request->input('description'); 

                //Create new RU if current user is not valid
                $ruId = 0;
                if($user->ru){
                    $ruId = $user->ru->id; 
                }else{
                    $ruId = RU::insertGetId(['user_id'=>$user->id, 'created_at'=>now()]); 
                }
                $report->member_id      = $ruId; 

                //Make report draft or publish
                if($request->input('is_saved') && $request->input('is_saved') == 1){
                    $report->is_posted      = 0; 
                }

                //Latlng provided from client
                $report->lat            = $lat; 
                $report->lng            = $lng; 
                $report->additional_location            = $request->input('additional_location'); 
                
                $report->created_at     = now();
                $report->save();

                //Updaate Coordiate system
                $str = "UPDATE pothole_reports Set `point` = GeomFromText('POINT(".$utm['x']." ".$utm['y'].")') WHERE `id`=".$report->id; 
                DB::update($str);

                //Check village within 1000; 
                $villages = RoadCare::getVillagesByLL($lat, $lng); 
                if(count($villages) > 0){
                    foreach($villages as $row){

                        $reportLocation               = new ReportLocation(); 
                        $reportLocation->report_id    = $report->id; 
                        $reportLocation->village_id   = $row->id; 
                        $reportLocation->distance     = number_format($row->distance, 2, '.', '');
                        $reportLocation->save(); 
                    }    
                }

                //Adding Files
                $image = ''; //For Notification
                $files =  json_decode($request->input('files')); 
                if(count($files) > 0){
                    foreach($files as $file){
                        $myFile = FileUpload::forwardFile($file->img, 'pothole'); 
                        $report->files()->insert([
                            'report_id'=>$report->id, 
                            'lat'=>$file->lat, 
                            'lng'=>$file->lng, 
                            'uri'=>$myFile
                        ]);

                        if($image == ''){
                            $image = $myFile; 
                        }
                    }
                }

                $report['files'] = $report->files()->select('id', 'report_id', 'uri')->where('report_id', $report->id)->get(); 
                if(count($report['files']) > 0){
                    
                    //Update point
                    $point               = new Point($utm['y'], $utm['x']);
                    $points              = []; 

                    $potholeLocation           = PotholeLocation::select('points')->where('pothole_id', $pothole->id)->first();
                    //return $potholeLocation;
                    if($potholeLocation->points){
                        $points = array_merge($potholeLocation->points->getPoints(), [$point]); 
                    }else{
                        $points          = [$point , $point]; //MulitPoint needs at least two points
                    }

                    $multiPoint     = new MultiPoint($points); 
                    $str = $multiPoint->toWKT(); //Convert to String

                    $str = str_replace("MULTIPOINT((", "", $str); 
                    $str = str_replace("),(", ", ", $str); 
                    $str = str_replace("))", "", $str);  
                    
                    //Update Spatial field
                    DB::update("update `pothole_location` set `points` = ST_MPointFromText('MULTIPOINT(".$str.")') where `pothole_id` = ".$pothole->id);

                    $strPoint = DB::select("Select ST_AsText(ST_Centroid(ST_GeomFromText('POLYGON((".$str."))'))) as strCentralPoint");
                    //return $strPoint[0]->strCentralPoint; 
                    if($strPoint[0]->strCentralPoint){
                        
                        //Update pothole central location as lat & lng
                        $strCentralPoint = $strPoint[0]->strCentralPoint; 
                        $strCentralPoint = str_replace("POINT(", "", $strCentralPoint); 
                        $strCentralPoint = str_replace(")", "", $strCentralPoint); 
                        $strCentralPoint = explode(" ", $strCentralPoint); 
                        $ll              = LatLngUMTConvert::utm2ll($strCentralPoint[0], $strCentralPoint[1]);

                        PotholeLocation::where('pothole_id', $pothole->id)->update(['lat'=>$ll['lat'], 'lng'=>$ll['lng']]);
                    }

                    
                    //===========================>>Send Notification to MO
                    if($road){

                        $relatedMO = MORoad::select('id', 'road_id', 'mo_id')->with(['mo:id,user_id'])->where('road_id', $road->pk->road_id)->first(); 
                        if($relatedMO){
                           
                             $metaData = [
                                'way'           =>  'firebase', 
                                'title'         =>  'New Pothole #'.$pothole->code, 
                                'image'         =>  $image, 
                                'description'   =>  $request->input('description'), 
                                'type'          =>  'Pending', 
                                'action'        => 'feeddetail', 
                                'action_id'     =>  $report->id
                            ]; 
                            $notify = Notify::send($relatedMO->mo->user_id, $metaData);
                        }
                           
                    }
                    //===========================>> Send Notification to RU
                    // $metaData = [
                    //     'way'           =>  'firebase', 
                    //     'title'         =>  'Create New Report', 
                    //     'image'         =>  $image, 
                    //     'description'   =>  'Your report has been sent to Maintenance office', 
                    //     'type'          =>  'Pending', 
                    //     'action'        => 'feeddetail', 
                    //     'action_id'     => $report->id
                    // ]; 
                    // $notify = Notify::send($user->id, $metaData);

                    //===========================>> Send Notification to MO

                    //Send Telegram
                    // $response = TelegramBot::sendMessage([
                    //     'chat_id' => 152262602, 
                    //     'text' => '<b>New Report Created</b>: RU has reported a pothole!',
                    //     'parse_mode' => 'HTML'
                    // ]);

                    return $this->view($report->id); 

                }else{
                    
                    $report->delete(); 
                    return response()->json([
                        'status_code'   =>  403,
                        'errors'        =>  ['message'  =>  ['Sorry! there is an error occured.']]
                    ], 403);
                }

            }else{
                return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['pothole could not be created.']]
                ], 403);
            }

        }else{
            return response()->json([
                'status_code'   =>  403,
                'errors'        =>  ['message'  =>  ['Please upload at least 1 file.']]
            ], 403);
        }      
    }

    function publishReport($reportId = 0){
        $report = Report::where('is_posted', 0)->find($reportId); 
        if($report){
            $report->is_posted = 1; 
            $report->posted_at = now(); 
            $report->save(); 
            return $this->view($report->id); 
        }else{
            return response()->json([
                    'status_code'   =>  403,
                    'errors'        =>  ['message'  =>  ['invalid report']]
                ], 403);
        }
    }

    function delete(Request $request){
        $message = ""; 
        $report = Report::find($request->get('reportId')); 
        if($report){
            $report->delete();
            $message .=" A report is deleted. ";  
        }

        $pothole = Pothole::find($request->get('potholeId')); 
        if($pothole){
            $pothole->delete(); 
            $message .=" A pothole is deleted. ";  
        }
        return response()->json([ 'message'   =>  $message ], 200);
    }

    function generatePotholeCode($potholeId){
        $code = date('y').date('m').'-'; 
        
        if($potholeId < 10){
            $code .= '0000000'.$potholeId;
        }elseif( $potholeId >= 10 && $potholeId < 100 ){
            $code .= '000000'.$potholeId;
        }elseif( $potholeId >= 100 && $potholeId < 1000 ){
            $code .= '00000'.$potholeId;
        }elseif( $potholeId >= 1000 && $potholeId < 10000 ){
            $code .= '0000'.$potholeId;
        }elseif( $potholeId >= 1000 && $potholeId < 100000 ){
            $code .= '000'.$potholeId;
        }elseif( $potholeId >= 100000 && $potholeId < 1000000 ){
            $code .= '00'.$potholeId;
        }elseif( $potholeId >= 1000000 && $potholeId < 1000000 ){
            $code .= '0'.$potholeId;
        }elseif( $potholeId >= 1000000 && $potholeId < 10000000 ){
            $code .= ''.$potholeId;
        }

        return $code;
    }

    function updatePotholeLocation($pothole){

    }

    function draft(){
        //Fetch authenticated user information
        $user = JWTAuth::parseToken()->authenticate();

        $data = Report::select('id', 'pothole_id', 'description', 'lat', 'lng', 'member_id', 'commune_id', 'created_at','additional_location', 'is_posted')
        ->with([
            'ru:id,user_id',
            'ru.user:id,name,avatar',
            'files:id,report_id,uri,lat,lng,is_accepted', 
            'comments'=>function($query){
                $query->select('id', 'report_id', 'creator_id', 'comment', 'created_at')
                ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
            }, 
            'pothole'=>function($query) use ($user){
                $query->select('id', 'created_at', 'point_id', 'code', 'maintence_id')
                ->with([
                     'comments'=>function($query){
                        $query->select('id', 'pothole_id', 'creator_id', 'comment', 'created_at')
                        ->with('commenter:id,name,avatar')->orderBy('id', 'DESC')->get();
                    }, 

                    'location:id,pothole_id,village_id,commune_id,district_id,province_id,lat,lng', 
                    'location.village:id,name,code', 
                    'location.commune:id,name,code', 
                    'location.district:id,name,code', 
                    'location.province:id,name,code', 

                    'point:id,pk_id,meter', 
                    'point.pk:id,code,road_id',
                    'point.pk.road:id,name,start_point,end_point',

                    'statuses'=>function($query){
                        $query->select('id', 'pothole_id', 'status_id', 'mt_id', 'updater_id', 'comment', 'updated_at')
                        ->with([
                            'status:id,name', 
                            'updater:id,name,avatar', 
                            'mt:id,user_id', 
                            'mt.user:id,name,avatar'
                        ])
                        ->orderBy('id', 'DESC')->get(); 
                    }, 
                    'files:uri,lat,lng'
                   
                ]); 
            }, 
            'locations'=>function($query){
                $query->select('id', 'report_id', 'village_id', 'distance')
                ->with([
                    'village:id,name,code,commune_id', 
                    'village.commune:id,name,code,district_id',
                    'village.commune.district:id,name,code,province_id', 
                    'village.commune.district.province:id,name,code'
                ]); 
            }, 

           // 'commune:id,name,code,dis'
        ])->withCount('comments as num_of_comments'); 

       
        $data = $data->where('is_posted', 0)
        // ->whereHas('ru', function($query) use ($user) {
        //     $query->whereHas('user', function($query) use ($user) {
        //         $query->where('id', $user->id); 
        //     });
        // })
        ->orderBy('id', 'desc')->first();
        return response()->json($data, 200);
    }
}
