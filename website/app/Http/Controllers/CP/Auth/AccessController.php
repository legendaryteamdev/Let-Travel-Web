<?php

namespace App\Http\Controllers\CP\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class AccessController extends Controller {
   
    public function showUnaccessForm() {
       return view('cp.auth.unaccess');
    }   

   
}