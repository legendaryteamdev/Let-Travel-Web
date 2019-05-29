<?php

namespace App\MPWT;


use Illuminate\Http\Request;
use Image;

class FileUpload{
    


    public static function forwardFile($file, $incommingFolder = 'unknown'){
        
        $dataFile = explode(',', $file);
        $ini =substr($dataFile[0], 11);
        $ext = explode(';', $ini);
        

        //extract data from the post
        //set POST variables
        $folder = 'public/uploads/'.env('FILE_FOLDER').'/'.$incommingFolder.'/'; 
        $fileName = uniqid().'.'.$ext[0]; 
        $fields = array(
            'file' => urlencode($file), 
            'folder'=> $folder,
            'fileName' => urlencode($fileName)
        );
        //return $folder.$fileName; 
        //url-ify the data for the POST
        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, env('FILE_URL').'/api/upload/64base');
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        //Check if file exist 
        return $folder.$fileName; 

    }


  
}
