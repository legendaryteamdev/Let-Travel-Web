<?php

namespace App\Http\Controllers\CP\Dashboard;

use Auth;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\CamCyber\FunctionController;
use App\Http\Controllers\CamCyber\GenerateSlugController as GenerateSlug;

use App\Model\Dashboard\Main as Model;
use Image;
class DashboardController extends Controller
{
    protected $route; 
    public function __construct(){
        $this->route = "cp.dashboard";
    }

    public function index(){
        
        return view($this->route.'.index', ['route'=>$this->route]);
    }

    public function getTicketLookUp(Request $request){
        $curl = curl_init();
        // if($request->get("reference_number") == null){
        //     return' ';
        // }
        // else{

          curl_setopt_array($curl, array(
            CURLOPT_PORT => "44310",
            CURLOPT_URL => "http://96.9.67.237:44310/api/v2.1.2/validate-vpn-invoice?partner=ACLEDA&reference_number=".$request->get("reference_number"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
              "Accept: */*",
              "Authorization: Basic acle05dd34cefb112d3444fp6mee7b86fcqy2719a5da",
              "Cache-Control: no-cache",
              "Connection: keep-alive",
              "Host: 96.9.67.237:44310",
              "Postman-Token: 00623840-9a1d-4a03-8681-5c978393c2d3,7c6a4357-414a-4b01-bf5e-8032cf996add",
              "User-Agent: PostmanRuntime/7.11.0",
              "accept-encoding: gzip, deflate",
              "cache-control: no-cache",
              "cookie: XSRF-TOKEN=eyJpdiI6Im5icG1VVmIyaVhZMVA3ZVRCTFNkc3c9PSIsInZhbHVlIjoiZlVySUw4b25TVjFrck5yeWI4cE95RmNybjByMm10WDd6Q0oxcHUwZ2NCRjNKdFA4XC9qODk1VlwvMkNvclNxazdTTFUzY1wvOHVUNTArMEhYOW01RXYyV1E9PSIsIm1hYyI6IjAxNmU5YTc3M2Y1ZDNlYzA4ZmQwZmRhNjcyNGI0MTEyZTQwMDU0YTNkMzQ4MjljNjczNTVmZGYxNGZhNTg3OTYifQ%3D%3D; laravel_session=eyJpdiI6Im52dWhmKytnbnNvVHlPZ2tkR0tqVlE9PSIsInZhbHVlIjoiZ1U5dUd4U1BMZ05YNVhtcFVSNUlMdDB5RGl2XC85Q2R2SE91ejkyajVZZ2F2TWNFSUtcL1VlOWxqWG8rS000cWh2SUVWR0FWaXRtajY4OVgyRFJSUnYwQT09IiwibWFjIjoiNmYzM2Y5YjNjMDhjZmM1ZWFkMDc4ODE0NDY1NDFmZWI4MTU3YTNjNWM0OGQ0MGYyOWVlZjEyM2ZkMDdhYWY4NiJ9"
            ),
          ));
          
          $response = curl_exec($curl);
          $err = curl_error($curl);
          
          curl_close($curl);
          
          if ($err) {
            echo "cURL Error #:" . $err;
          } else {
            echo $response;
          }
    }

    public function submitPayment(Request $request){
      //extract data from the post
        //set POST variables
        
        $fields = array(
            'partner' => 'ACLEDA', 
            'reference_number'=> '1215757278808',
            'transaction_id' => '1905170100',
            'session_id'  => '5TN3zk9Cin4cyqiBY5T4C7qqvgimOGJKNoI5Qy3y'

        );
        //return $folder.$fileName; 
        //url-ify the data for the POST
        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, 'http://96.9.67.237:44310/api/v2.1.2/submit-vpn-invoice');
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

    public function commitPayment(Request $request){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_PORT => "44310",
        CURLOPT_URL => "http://96.9.67.237:44310/api/v2.1.2/submit-vpn-invoice",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"partner\"\r\n\r\nACLEDA\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"reference_number\"\r\n\r\n1221766518246\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"transaction_id\"\r\n\r\n1905070940\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"session_id\"\r\n\r\nDq58aN8ZUrpm4wBpz1Es0kD8hrEhIc2GwHRf8aSD\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
          "Accept: */*",
          "Authorization: Basic acle05dd34cefb112d3444fp6mee7b86fcqy2719a5da",
          "Cache-Control: no-cache",
          "Connection: keep-alive",
          "Host: 96.9.67.237:44310",
          "Postman-Token: 605e6446-124f-4db9-8c96-6936a0548c3b,b3c698c2-a29b-4e5f-82dd-f67edcf55350",
          "User-Agent: PostmanRuntime/7.13.0",
          "accept-encoding: gzip, deflate",
          "cache-control: no-cache",
          "content-length: 568",
          "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
          "cookie: XSRF-TOKEN=eyJpdiI6IlVtSjVldWhjZDRWK0V4QWxxUkoxZFE9PSIsInZhbHVlIjoiZ0NpSStveDZEZDgwOWpUbGxyMkJPMVF1MitQM05DWGxhOTVQOTQxUlRVQlliMDZWNmJzdHgrNmtKQnRcL295MFdDXC9xdzNCU0NDd3F5MzVBQmQ5WjhBZz09IiwibWFjIjoiMTMyZmM0OWFkMzdkZTFhM2Y4ODgzYmYwYTU4YmQzYjVhNDUwZTVlYjEwZmU3OTY0ZjBjZGFmYmZmMjkwMjdhNCJ9; laravel_session=eyJpdiI6ImVhZHBRQmJybjFLNEZmOVR0Ujc3RXc9PSIsInZhbHVlIjoiVURsT1l0Z3YwaVBNVmljQUZKUzFmdDRMTW9nU1FZSk5VRFBURUl3QktVNjF0RUxkM3VcL0lPTmdvS3ZaNFhGSGc5Y09cL295ZUlhcllPTHNHZHRVRmtCQT09IiwibWFjIjoiY2NmYTNhNjQ1ZGMzMzQwOGUwMmY2N2VkY2M0ZTVhMWNlNjhiZWZiNDI5N2IwOWQxYzMwMWE2NDg4ZGM1Y2JmNCJ9"
        ),
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        echo $response;
      }
    }

   
   
    
}
