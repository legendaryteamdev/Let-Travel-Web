<?php

namespace App\Http\Controllers\CamCyber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FunctionController extends Controller
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

    public static function isValidDate($date){
      if (false === strtotime($date)) {
          return false;
      }else {
          return true;
      }
    }

    public static function who($id){
      $data = DB::table('users')->select('en_name as name')->where('id', $id)->first();
      if(count($data) == 1){
        return $data->name;
      }else{
        return "Unknown";
      }
      
    }

  
}
