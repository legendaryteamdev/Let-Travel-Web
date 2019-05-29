<?php

namespace App\Http\Controllers\CamCyber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class GenerateSlugController extends Controller
{
   
   
    

    public static function generateSlug($tbl='', $text='', $id =0){
         // replace non letter or digits by -
          $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
          // trim
          $text = trim($text, '-');
          // transliterate
          if (function_exists('iconv')){
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          }
          // lowercase
          $text = strtolower($text);
          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);
          if (empty($text)){
            return 'n-a';
          }
          
          $data = DB::table($tbl)->select('id','slug')->where('slug', $text)->first();
          
         
          if(!empty($data)){
            if($id != 0){
              return $id.'-'.$text;
            }else{
              $next_id = DB::table($tbl)->orderBy('id', 'desc')->first()->id+1;
              return $next_id.'-'.$text;
            }
            
          }else{
              return $text;
          }
    }
}
