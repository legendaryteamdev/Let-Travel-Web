<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function index(){
        return view('frontend.about-us.about');

    }
}

  