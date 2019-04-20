<?php
namespace App\Api\V1\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Model\User as User;

class ApiController extends BaseController
{

    public function __construct(){
        App::setLocale('kh');
    }

    use DispatchesJobs, ValidatesRequests;
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            throw new ValidationHttpException($validator->errors());
        }
    }

    function checkUserPosition($userId = 0){
        $user = array(); 
        if($userId != 0){
            $user = User::find($userId); 
        }else{
            $user = JWTAuth::parseToken()->authenticate(); 
        }

    	
        $roles = []; 
        if($user->admin){
            $roles[] = 'am';  //Admin
        }
        if($user->mo){
            $roles[] = 'mo'; //Maintenance Office
        }
        if($user->mt){
            $roles[] = 'mt'; //Maintenance Team
        }
        if($user->ru){
            $roles[] = 'ru'; // Road User
        }
        return $roles;
    }
 
   
    

}