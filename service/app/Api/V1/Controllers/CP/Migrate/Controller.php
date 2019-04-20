<?php

namespace App\Api\V1\Controllers\CP\Migrate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\MultiPoint;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Geometry;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;

use App\Api\V1\Controllers\ApiController;

use App\Model\Road\Data;
use App\Model\Road\Main as Road;
use App\Model\Road\Part as Part;
use App\Model\Road\Type as Type;
use App\Model\Road\PK as PK;
use App\Model\Road\Point as PKPoint;
use App\Model\Road\PKPart as PKPart;
use App\Model\Road\Province as RoadProvince;
use App\Model\Authority\Ministry\Road as RoadMinsitry;
use App\Model\Authority\MO\Road as RoadMo;
use App\Model\Authority\MT\Main as MT;
use App\Model\Authority\MT\Road as RoadMT;

use App\Model\Location\Province;
use App\Model\Location\District;
use App\Model\Location\Commune;
use App\Model\Location\CommunePoint;
use App\Model\Location\Village;

use Illuminate\Support\Facades\DB;
use App\MPWT\LatLngUMTConvert; 

class Controller extends ApiController
{
   
    function location(){
        DB::statement(file_get_contents(asset('public/data/province.txt')));
        DB::statement(file_get_contents(asset('public/data/district.txt'))); 
        DB::statement(file_get_contents(asset('public/data/commune.txt'))); 
        DB::statement(file_get_contents(asset('public/data/village.txt'))); 

        //DB::statement(file_get_contents(asset('public/data/boundary.txt'))); 

        // $data = Village::select('id', 'central')->where('id', '>=', 4393)->get();
        // foreach($data as $row){
        //     $ll = LatLngUMTConvert::utm2ll($row->central->getLng(), $row->central->getLat()); 

        //     $row->lat = $ll['lat']; 
        //     $row->lng = $ll['lng']; 
        //     $row->save(); 

        //     //return $ll; 
        // }

        return "done"; 

    }

    function addBoundaries(){
        $provinces = Province::select('code')->get(); 
        $nOfCommunes = 0; 
        foreach($provinces as $row){
            $nOfCommunes += $this->boundary($row->code); 
            
        }

        return $nOfCommunes; 
    }

    function boundary($code){
        $str = file_get_contents("http://localhost/MPWT/roadcare/service/public/data/commune.json");
        $json = json_decode($str, true);
        $communes = []; 
        if ($json['type'] === 'FeatureCollection') {
            
            $sql = ""; 
            $nOfCommunes = 0; 

            foreach($json['features'] as $feature){
                if($feature['properties']['Codekhum'] != '' && $feature['properties']['codesrok'] != ''){
                    $district = District::select('id', 'province_id')->where('code', $feature['properties']['codesrok'])->first(); 
                    if($district){
                        if($code == $district->province_id){
                            

                            $points = $feature['geometry']['coordinates'][0]; 
                            $str = ""; 
                            $nOfPoints = count($points); 
                            for($i = 0; $i < $nOfPoints ; $i++){
                                $str .= $points[$i][0]." ".$points[$i][1]; 

                                if($i < $nOfPoints-1){
                                    $str.=", ";
                                }
                            }
                            
                            if($str != ""){
                                $sql .= "update `commune` set `boundary` = ST_PolygonFromText('LINESTRING(".$str.")')  where `code` =".$feature['properties']['Codekhum'].";\n";  
                                $nOfCommunes ++; 
                            }
                        }      
                    }     
                }
            }

       
            $provinceBoundary = fopen("public/data/boundary/".$code.".txt", "w") or die("Unable to open file!");
            fwrite($provinceBoundary, $sql);
            fclose($provinceBoundary);


            return $nOfCommunes; 

        }
    }

 

    function createRoadData(){
        DB::statement("
                CREATE TABLE `road_data` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `road` CHAR(50) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
                    `start_point` CHAR(50) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
                    `end_point` CHAR(50) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
                    `digit` CHAR(50) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
                    `object_id` INT(11) NULL DEFAULT '0',
                    `road_type` CHAR(50) NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
                    `provinces` CHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
                    `length` DECIMAL(60,2) NULL DEFAULT '0',
                    `shape` LINESTRING NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                )
                COLLATE='utf8_unicode_ci'
                ENGINE=InnoDB
                AUTO_INCREMENT=2084;
            ");

 
        DB::statement(file_get_contents(asset('public/data/road_data.txt'))); 
        echo 'success'; 
    }

    function road(){
        $numOfProvinces = 0; 
        $numOfProvincesFound = 0; 

        $roads = Data::select('road')->distinct()->get(); 
        foreach($roads as $row){
            
            $data = Data::select('road', 'start_point', 'end_point', 'provinces')->where('road', $row->road)->first(); 
            if($data){
                if($data->start_point != ""){
                    //=================================>> create road
                    $road               = new Road(); 
                    $road->name         = $data->road; 
                    $road->start_point  = $data->start_point; 
                    $road->end_point    = $data->end_point; 
                    $road->save(); 

                    //=================================>> Create Road Province
                    $provinces = explode(",", $data->provinces);
                    $numOfProvincesFound += count($provinces); 

                    foreach($provinces as $abbre){
                        $abbre = str_replace(" ", "", $abbre); 
                        $myProvince = Province::select('id')->where('abbre', $abbre)->first(); 
                        if($myProvince){
                            $dataProvicne = new RoadProvince(); 
                            $dataProvicne->province_id = $myProvince->id; 
                            $dataProvicne->road_id = $road->id;
                            $dataProvicne->save(); 
                            $numOfProvinces ++; 
                        }
                    }
                }
            }
        }
        return response()->json(['message'=>'success', 'numOfProvincesFound'=>$numOfProvincesFound, 'numOfProvinces'=>$numOfProvinces], 200);
    }

    function part(){
        $roads = Road::select('id', 'name')->get(); 
        foreach($roads as $road){
            
            $data = Data::select('object_id', 'road_type', 'length', 'shape')->where('road', $road->name)->get(); 
            $totalPart = "LINESTRING()"; 
            $totalLength = 0; 
            foreach($data as $row){
                
                $part = new Part(); 
                $part->road_id      = $road->id; 
                $part->object_id    = $row->object_id;  
                $part->length       = $row->length; 
                $part->line         = $row->shape; 
                 

                $type = Type::select('id')->where('name', 'LIKE', '%'.$row->road_type.'%')->first(); 
                if($type){
                    $part->type_id = $type->id; 
                }
                
                if( $row->road_type == "Paved Road" || $row->road_type == "Pave Road" ){
                    $part->type_id = 1; 
                }elseif( $row->road_type == "Footpath"){
                    $part->type_id = 2; 
                }elseif( $row->road_type == "Laterite Road" || $row->road_type == "Laterite" ){
                    $part->type_id = 3; 
                }elseif( $row->road_type == "Road"){
                    $part->type_id = 4; 
                }elseif( $row->road_type == "Carttrack"){
                    $part->type_id = 5; 
                }elseif( $row->road_type == "Street"){
                    $part->type_id = 6; 
                }

                $part->save(); 

                //Part total
                $y =  DB::select("Select ST_AsText(ST_Union(ST_LineStringFromText('".$totalPart."'), ST_LineStringFromText('".$row->shape->toWKT()."'))) as x");
                $totalPart = $y[0]->x;
                $totalLength += $row->length; 
            }



            $road->length = $totalLength; 
            $road->save();

        }
        return response()->json(['message'=>'success'], 200);
    }

    function convert(){
        $parts = Part::select('id', 'line')->get(); 
        foreach($parts as $row){
            $points = $row->line->toArray();
            $myPoints = []; 
            for($i = 0; $i < count($points); $i++){
                $myPoints[] = new Point($points[$i]->getLat(), $points[$i]->getLng()); 
            }
            $row->line = new Point(['lng'], ['lat']); 
            $row->save(); 
        }
        return response()->json(['message'=>'success'], 200);
    }

    function checkByPoint(Request $request){
        $utm            = LatLngUMTConvert::ll2utm($request->get('lat'), $request->get('lng')); 

        $point = PKPoint::select(
            'id',
            'pk_id',
            DB::raw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance")
        )
        ->with([
            'pk:id,code,part_id', 
            'pk.part:id,object_id,road_id,type_id', 
            'pk.part.road:id,name', 
            'pk.part.type:id,name'
        ])
        ->whereRaw("ST_Distance(`point`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$request->get('r'))
        ->orderBy('distance', 'ASC')
        ->first();

        $village = Village::select(
            'id', 
            'name', 
            DB::raw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance")
        )
        ->with([
            'commune:id,name,district_id', 
            'commune.district:id,name,province_id', 
            'commune.district.province:id,name'
        ])
        ->whereRaw("ST_Distance(`central`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$request->get('r'))
        ->orderBy('distance', 'ASC')
        ->first(); 

        return response()->json(['point'=>$point, 'village'=>$village], 200);
    }


    //=========================================================>> Migrate By Point
    function migratePKPointByPoint(){
        $roads = Road::select('id', 'name')->where('is_point_migrated', 0)->get(); 
        $numOfRoads = 0; 
       
        foreach($roads as $row){
            $fileUrl = "public/data/road/".$row->name.".json";
            if(file_exists($fileUrl) == 1){
                $this->pkpoint($fileUrl, $row->name); 

                $row->is_point_migrated = 1; 
                $row->migrate_method = 'point'; 
                $row->save(); 
                
                $numOfRoads++; 
            }
        }

        return ['numOfRoads'=>$numOfRoads]; 
    }

    function pkpoint($fileUrl = "", $road ="", $r = 99){
       

        $string = file_get_contents($fileUrl);
        $json = json_decode($string, true);
        $parts  = []; 
       
        $totalPoints = 0; 
        $allPoints = []; 

        foreach ($json as $key => $row) {
           
            //Check if X and Y belong to any parts
            $utm = LatLngUMTConvert::ll2utm($row['Y'], $row['X']); 
           
            $data = Part::select('id', 'road_id', 'object_id', 'line', DB::raw("ST_Distance(`line`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) as distance"))
            ->with('road:id,name')
            ->whereHas('road', function($query) use ($road){
                $query->where('name', $road); 
            })
            //->where('object_id', 1657)
            ->whereRaw("ST_Distance(`line`, ST_GeomFromText('Point(".$utm['x']." ".$utm['y'].")')) <= ".$r)
            ->orderBy('distance', 'ASC')
            ->first(); 

            $temPoints = []; 

            if($data){

                $dataPK = explode('+', $row['PK']); 
                $point = ['x'=>$utm['x'], 'y'=>$utm['y']];

                $keyPart = $data->road->id.'-'.$data->id.'-'.$data->object_id; 

                if(!isset($parts[$keyPart])){
                    $parts[$keyPart] = [$dataPK[0] => [$dataPK[1]=>$point]];
                }else{
                    foreach($parts[$keyPart] as $pk => $points){
                        
                        if($pk == $dataPK[0]){
                            $temPoints = $points; 
                            $temPoints[$dataPK[1]] = $point; 
                        }else{
                            if(count($temPoints) == 0){
                                $temPoints[$dataPK[1]] = $point; 
                            }
                        }
                    }
                    $parts[$keyPart][$dataPK[0]] =  $temPoints;
                }
                
                $totalPoints++; 
                $allPoints[] = $point; 
            }
        }

        $nOfParts = 0; 
        $nOfPKs = 0;
        $nOfPoints = 0; 
        $myPKs = []; 
        foreach($parts as $part => $pks){
            foreach($pks as $pk => $points){
                
                $dataPart         = explode("-", $part); 
                //Check if this pk has already had in the record
                $PKData  = PK::select('id')->where(['road_id'=>$dataPart[0], 'code'=>$pk])->first();
                if(!$PKData){
                    $PKData             = new PK(); 
                    $PKData->road_id    = $dataPart[0]; 
                    $PKData->code       = $pk;
                    $PKData->save();
                }
                //Check if this PK already had in this part
                $credentail             = ['pk_id'=>$PKData->id, 'part_id'=>$dataPart[1]]; 
                $PKPartData              = PKPart::select('id')->where( $credentail)->first(); 
                if(!$PKPartData){
                    PKPart::insert($credentail); 
                }

                foreach($points as $meter => $point){
                    DB::insert('INSERT INTO road_pk_points (`pk_id`, `point`, `meter`, `created_at`) VALUES ('.$PKData->id.', GeomFromText("POINT('.$point['x'].' '.$point['y'].')"), "'.$meter.'", "'.now().'")');
                    $nOfPoints++;
                }
                $nOfPKs++;
            }
            $nOfParts++; 
        }
    }

   
    //=========================================================>> Migrate By CSV
    function migratePKPointbyCsv(){

        $roads = Road::select('id', 'name')->where('is_point_migrated', 0)->orderby('name', 'asc')->get(); 
        $numOfRoads = 0; 
       
        foreach($roads as $road){
          
            $fileUrl = "public/data/road/csv/".$road->name.".json";
            if(file_exists($fileUrl) == 1){
                $string = file_get_contents($fileUrl);
                //return $string; 

                $json = json_decode($string, true);
                //return count($json); 

                foreach($json as $row => $key){
                   
                    
                    $pkpoint = explode('+', $key['PK']); 
                    //return $pkpoint;
                    $PKData  = PK::select('id')->where(['road_id'=>$road->id, 'code'=>$pkpoint[0]])->first();
                    if(!$PKData){
                        $PKData             = new PK(); 
                        $PKData->road_id    = $road->id; 
                        $PKData->code       = $pkpoint[0];
                        $PKData->save();
                       
                    }

                    $utm = LatLngUMTConvert::ll2utm($key['Y'], $key['X']); 
                    //Insert Point
                    DB::insert('INSERT INTO road_pk_points (`pk_id`, `point`, `meter`, `created_at`) VALUES ('.$PKData->id.', GeomFromText("POINT('.$utm['x'].' '.$utm['y'].')"), "'.$pkpoint[1].'", "'.now().'")');
                   
                }
                //Update Road status
                $road->is_point_migrated = 1; 
                $road->migrate_method = "csv"; 
                $road->save(); 

                $numOfRoads++; 
            }

           
            
        }

        return ['numOfRoads'=>$numOfRoads]; 
            
    }

    //=========================================================>> Migrate By Line
    function migratePKPointByLine(Request $request){
        $roadName = $request->get('roadName'); 
        
        //Part of Primary road
        $parts = Part::select('id', 'line')->whereHas('road', function($query) use ($roadName){
            $query->where('is_point_migrated', 1)->where('name', $roadName); 
        })->get();
        

        if(count($parts) > 0){
            $totalLineString = $this->sumLineString($parts); 
           

            if($totalLineString != ""){
                
                //Find any parts that connect to primary road
                $parts = Part::select(
                    'id', 
                    'road_id', 
                    'object_id', 
                    'length',
                    DB::raw("ST_AsText(ST_Intersection(`line`, ST_LineStringFromText('".$totalLineString."'))) as intersection")

                )->with(['road:id,name,length'])->whereHas('road', function($query) use ($roadName){
                    $query->where('is_point_migrated', 0)->where('name', 'Like', $roadName.'%'); 
                })
                ->whereRaw("ST_Intersects(`line`, ST_LineStringFromText('".$totalLineString."')) = 1")
                
                ->get();

                //Combine all secondary parts and take its name as key
                $roads = []; 

                if(count($parts) > 0){
                    foreach($parts as $row){
                        $roadName = $row->road->name; 

                        $relatedParts = Part::select('id', 'line')->whereHas('road', function($query) use ($roadName){
                            $query->where('is_point_migrated', 0)->where('name', $roadName); 
                        })->get();
                        
                        $totalLineString = $this->sumLineString($relatedParts);
                         //Start migrating Point and PK
                        $roads[$roadName] = $this->generatePKPoint($row->road->id,  $totalLineString); 
                    }
                }

               
                return $roads; 
            }
               
        }else{

            return "Road not valid";         
        }
    }

    function sumLineString($parts){
        $totalLineString = ""; 
        $lines = []; 
        $i = 0; 
        foreach($parts as $part){
            $myLine = $part->line->toWKT(); 
            $i++; 
            
            $lines[$i] = $myLine;
        }
       
        $startLine = $lines[1]; 
        unset($lines[0]);

        return $this->merching($lines, $startLine);
    }

    function merching($lines, $myLine){
       
        
        if(count($lines) > 0){

            foreach($lines as $i => $line){
                
                $distance = DB::select("Select ST_Distance(ST_LineStringFromText('".$myLine."'), ST_LineStringFromText('".$line."')) as distance");
                if($distance[0]->distance == 0){
                    $y =  DB::select("Select ST_AsText(ST_Union(ST_LineStringFromText('".$myLine."'), ST_LineStringFromText('".$line."'))) as x");
                    $myLine = $y[0]->x; 
                    unset($lines[$i]); 
                    return $this->merching($lines, $myLine);
                }
            }

            
        }else{
            return $myLine;
        }
    }

    function generatePKPoint($roadId =0, $totalLineString = ""){
        $length = DB::select("Select ST_Length(ST_LineStringFromText('".$totalLineString."')) as length");
        $length = $length[0]->length; 
        
       
        $nOfPKs = 0;
        $totalPoints = 0; 

        if($length > 0){
            $sp = DB::select("Select ST_AsText(ST_StartPoint(ST_LineStringFromText('".$totalLineString."'))) as sp"); 
            $sp = $sp[0]->sp;
            
            $currentPK = 0; 
            $pkId = 0; 
            
           
            $nOPoints = 0; 
            $meter = 0; 

            for($m = 0; $m < $length ; $m = $m+100){
                //Start to create a PK
                if($nOPoints == 0 ){
                    $PK             = new PK(); 
                    $PK->road_id    = $roadId; 
                    $PK->code       = $currentPK;
                    $PK->save();
                    $pkId = $PK->id; 
                    $nOfPKs++; 
                    $meter = 0; 
                }

                $c = DB::select("Select ST_AsText(ST_Buffer(ST_PointFromText('".$sp."'), 100)) as c"); 
                $r = DB::select("Select ST_AsText(ST_Intersection(ST_LineStringFromText('".$totalLineString."'), ST_GeomFromText('".$c[0]->c."'))) as r"); 
                DB::insert('INSERT INTO road_pk_points (`pk_id`, `point`, `meter`, `created_at`) VALUES ('.$pkId.', GeomFromText("'.$sp.'"), "'.$meter.'", now())');
                $totalPoints++; 
                $sp = DB::select("Select ST_AsText(ST_StartPoint(ST_LineStringFromText('".$r[0]->r."'))) as sp"); 
                $sp = $sp[0]->sp;

                $meter = $meter + 100; 
                $nOPoints ++; 
                if($nOPoints == 10){
                    $nOPoints = 0; 
                    $currentPK++; 
                }
            }

            
        }

        $road = Road::find($roadId); 
        $road->is_point_migrated = 1;
        $road->migrate_method = 'line';
        $road->save();

        return ['nOfPKs'=>$nOfPKs, 'nOPoints'=>$totalPoints, 'lenght'=>$length];   
    }

    //=========================================================>> Migrate Road Location
    function migrateRoadLocation(){
        $roads = Road::select('id', 'name')->where('is_location_migrated', 0)->orderBy('name', 'ASC')->limit(10)->get(); 
        $numOfRoads = 0; 
       
        foreach($roads as $row){
            $this->operateRoadLocationMigration($row->name); 
            $row->is_location_migrated = 1; 
            $row->save(); 

            $this->assignRoadToMT($row->name); 
            $numOfRoads++; 
            
        }

        return ['numOfRoads'=>$numOfRoads]; 
    }

    function operateRoadLocationMigration($roadName){
       
        $points = PKPoint::select('id', 'pk_id', 'point')->whereHas('pk', function($query) use ($roadName){
            $query->whereHas('road', function($query) use ($roadName){
                $query->where(['name'=>$roadName]); 
            });
        })->get();

        
        foreach($points as $point){
            if($point->point != null){
                $communes = Commune::select(
                            'id', 
                            DB::raw("ST_Distance(`boundary`, ST_PointFromText('".$point->point->toWKT()."')) as length")
                            )->whereRaw("ST_Contains(`boundary`, ST_PointFromText('".$point->point->toWKT()."')) = 1")->get(); 
               

                if(count($communes) > 0 ){

                    foreach($communes as $commune){
                        
                        $data = new CommunePoint; 
                        $data->commune_id = $commune->id; 
                        $data->point_id = $point->id; 
                        $data->length = $commune->length; 
                        $data->save(); 
                        
                    }

                }
            }
            
        }
        return 0; 
       
    }

    //=========================================================>> Assign Road To Authority
    function assignRoadToAuthority(){
        $roads = Road::select('id', 'name')->where('is_point_migrated', 1)->get();
        $nOfMigarations = 0; 
        foreach($roads as $road){
            $start = PK::select('id', 'code')->where('road_id', $road->id)->orderBy('code', 'ASC')->first(); 
            $end = PK::select('id', 'code')->where('road_id', $road->id)->orderBy('code', 'DESC')->first(); 

            if($start && $end){
                
                //Assign ministry to manage all roads
                $ministry                  = new RoadMinsitry(); 
                $ministry->road_id         = $road->id; 
                $ministry->ministry_id     = 1; //MPWT
                $ministry->start_pk        = $start->code; 
                $ministry->end_pk          = $end->code; 
                //$ministry->save(); 

                //Assign MO to manage all roads
                $mo                  = new RoadMo(); 
                $mo->road_id         = $road->id; 
                $mo->mo_id          = 1; //Head Office
                $mo->start_pk        = $start->code; 
                $mo->end_pk          = $end->code; 
                //$mo->save(); 

                //Assign 2 MTs to manage all roads
                $mt1                  = new RoadMT(); 
                $mt1->road_id         = $road->id; 
                $mt1->mt_id           = 26; 
                $mt1->start_pk        = $start->code; 
                $mt1->end_pk          =$end->code; 
                //$mt1->save();

                $mt2                  = new RoadMT(); 
                $mt2->road_id         = $road->id; 
                $mt2->mt_id           = 27; 
                $mt2->start_pk        = $start->code; 
                $mt2->end_pk          =$end->code; 
                //$mt2->save();

                $nOfMigarations++; 

            }
        }

        return ['nOfMigarations'=>$nOfMigarations, 'roads'=>$roads]; 

    }

    function assignRoadToMT($roadName= ""){
       
        $road = Road::where(['is_point_migrated'=>1, 'is_location_migrated'=>1, 'name'=>$roadName])->first();
        if($road){
            $pks = PK::select('id', 'code')->with(['points:id,pk_id'])->orderBy('code', 'ASC')->where('road_id', $road->id)->get();
            
            $provinces = []; 

            foreach($pks as $pk){
                $communes = CommunePoint::select('id', 'commune_id', 'point_id')->with(['commune:id,district_id', 'commune.district:id,province_id,name', 'point:id,meter'])->whereHas('point', function($query) use ($pk){
                    $query->where('pk_id', $pk->id); 
                })->get(); 
                //return $communes; 

                if(count($communes) > 0){
                    foreach($communes as $commune){
                        if($commune->commune->district->province_id){
                            if(!isset($provinces[$commune->commune->district->province_id])){
                                $provinces[$commune->commune->district->province_id][] = $pk->code; 
                            }else{
                                if(!in_array($pk->code, $provinces[$commune->commune->district->province_id])){
                                    $provinces[$commune->commune->district->province_id][] = $pk->code; 
                                }
                            }
                        }
                        
                    }
                }     
            }

            if(count($provinces) > 0){
                foreach($provinces as $provinceId => $pks){
                    //Find MT by Province
                    $mt = MT::where('province_id', $provinceId)->first(); 
                    if($mt){
                        $data                  = new RoadMT(); 
                        $data->road_id         = $road->id; 
                        $data->mt_id           = $mt->id; 

                        $data->start_pk        = $pks[0]; 
                        $data->end_pk          = $pks[count($pks)-1]; 
                        $data->save();
                    }   
                }
            }
 
        }

    }

}
