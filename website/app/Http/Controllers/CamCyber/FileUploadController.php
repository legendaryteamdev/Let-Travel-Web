<?php

namespace App\Http\Controllers\CamCyber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileUploadController extends Controller
{
   
   
    public static function uploadFile($request, $file, $directory = "uploads"){
    	if ($request->hasFile($file)) {
    		$file = $request->file($file);
    		if($file->isValid()){
    			//echo $file->path(); die;

    			$fileName = time().'.'.$file->getClientOriginalExtension();
		    	$path = $file->move(public_path($directory), $fileName);
		    	return 'public/'.$directory.'/'.$fileName;
    		}
    		
    		
    	}
    	
		return "";
    }
}
