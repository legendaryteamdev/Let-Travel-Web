<?php

namespace App\Http\Controllers\CamCyber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
   
   
    private static $agent = "";
    private static $info = array();

    function __construct(){
        self::$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
        self::getbrowser();
        self::getOS();
    }

    public static function getbrowser(){
        $browser = array("Navigator"            => "/Navigator(.*)/i",
                         "Firefox"              => "/Firefox(.*)/i",
                         "Internet Explorer"    => "/MSIE(.*)/i",
                         "Google Chrome"        => "/chrome(.*)/i",
                         "MAXTHON"              => "/MAXTHON(.*)/i",
                         "Opera"                => "/Opera(.*)/i",
                         );
        foreach($browser as $key => $value){
            if(preg_match($value, self::$agent)){
                self::$info = array_merge(self::$info,array("browser" => $key));
                self::$info = array_merge(self::$info,array(
                  "version" => self::getversion($key, $value, self::$agent)));
                break;
            }else{
                self::$info = array_merge(self::$info,array("browser" => "UnKnown"));
                self::$info = array_merge(self::$info,array("version" => "UnKnown"));
            }
        }
        return self::$info['browser'];
    }

    public static function getOS(){
        $OS = array("Windows"   =>   "/Windows/i",
                    "Linux"     =>   "/Linux/i",
                    "Unix"      =>   "/Unix/i",
                    "Mac"       =>   "/Mac/i"
                    );

        foreach($OS as $key => $value){
            if(preg_match($value, self::$agent)){
                self::$info = array_merge(self::$info,array("os" => $key));
                break;
            }
        }
        return self::$info['os'];
    }

    public static function getversion($browser, $search, $string){
        $browser = self::$info['browser'];
        $version = "";
        $browser = strtolower($browser);
        preg_match_all($search,$string,$match);
        switch($browser){
            case "firefox": $version = str_replace("/","",$match[1][0]);
            break;

            case "internet explorer": $version = substr($match[1][0],0,4);
            break;

            case "opera": $version = str_replace("/","",substr($match[1][0],0,5));
            break;

            case "navigator": $version = substr($match[1][0],1,7);
            break;

            case "maxthon": $version = str_replace(")","",$match[1][0]);
            break;

            case "google chrome": $version = substr($match[1][0],1,10);
        }
        return $version;
    }

    public static function showInfo(){
        return self::$info;
    }
}
