<?php

namespace App\Api\V1\Controllers\Test;

use App\Api\V1\Controllers\ApiController;
use Dingo\Api\Routing\Helpers;
use App\MPWT\SMS;


class Controller extends ApiController
{
    use Helpers;
   
    function sendSMS(){
        $sms = SMS::sendSMS('0965416704', 'Hi from MPWT​  សូមអគុណ!');
        if($sms['status'] == 'success'){
            return response()->json($sms, 200);
        }else{
            return response()->json($sms, 422);
        }
    }

    function forwardFile(){
        //var_dump($_FILES);
        $ch = curl_init('http://localhost/MPWT/roadcare/files/api/upload');
        $cfile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
        $data = array('file' => $cfile);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
    }

    // function makeCurlFile($file){
    //     $mime = mime_content_type($file);
    //     $info = pathinfo($file);
    //     $name = $info['basename'];
    //     $output = new CURLFile($file, $mime, $name);
    //     return $output;
    // }

    //http://localhost/MPWT/roadcare/file/api/upload
}
