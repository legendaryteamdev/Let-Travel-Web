@extends('cp/layouts.master')

@section ('headercss')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset ('public/user/css/lib/font-awesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('public/user/css/lib/bootstrap-sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset ('public/user/css/main.css') }}">
    <script type="text/javascript" src="{{ asset ('public/user/js/lib/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset ('public/user/css/lib/summernote/summernote.css') }}"/>
    <link rel="stylesheet" href="{{ asset ('public/cp/css/paymentbox.css') }}"/>
    @yield('appheadercss')
@endsection



@section ('bodyclass')
    class="with-side-menu control-panel control-panel-compact"
@endsection

@section ('header')

<header class="site-header">
    <div class="container-fluid">
        <a target="_blank" href="{{ url('/') }}" class="site-logo">
            <img style="padding: 10px;" class="hidden-md-down" src="{{ asset ('public/user/img/earth.png') }}" alt="">
            <img class="hidden-lg-up" src="{{ asset ('public/user/img/earth.png') }}" alt="">
        </a>
        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset (Auth::user()->picture) }}" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="{{ route('cp.user.profile.edit') }}"><span class="fa fa-user"></span> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('cp.auth.logout') }}"><span class="fa fa-sign-out"></span> Logout</a>
                        </div>
                    </div>

                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div><!--.site-header-shown-->

                <div class="mobile-menu-right-overlay"></div>
                
            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->
@endsection

@section ('menu')
    @php ($menu = "")
    @if(isset($_GET['menu']))
        @php( $menu = $_GET['menu'])
    @endif
    

    <div class="mobile-menu-left-overlay"></div>
    <nav class="side-menu">

        <ul class="side-menu-list"> 
        
        <li class="red @yield('active-main-menu-banner')">
                <a href="{{ route('cp.dashboard.index') }}">
                <span>
                    <i class="fa fa-dashboard"></i>
                    <span class="lbl">Dashbaord</span>
                </span>
                </a>
            </li>
            <li class="red @yield('active-main-menu-banner')">
                <a href="{{ route('cp.dashboard.index') }}">
                <span>
                    <i class="fa fa-dashboard"></i>
                    <span class="lbl">Province</span>
                </span>
                </a>
            </li>
            <li class="red @yield('active-main-menu-banner')">
                <a href="{{ route('cp.dashboard.index') }}">
                <span>
                    <i class="fa fa-dashboard"></i>
                    <span class="lbl">Resort</span>
                </span>
                </a>
            </li>
            <li class="red @yield('active-main-menu-banner')">
                <a href="{{ route('cp.dashboard.index') }}">
                <span>
                    <i class="fa fa-dashboard"></i>
                    <span class="lbl">Image</span>
                </span>
                </a>
            </li>
            <li class=" @yield('active-main-menu-user') red with-sub">
                <span>
                    <i class=" font-icon fa fa-users"></i>
                    <span class="lbl"> Users</span>
                </span>
                <ul>
                    <li class=""><a href="{{ route('cp.user.user.index') }}"><span class="lbl">User</span></a></li>
                    {{-- <li class=""><a href="{{ route('cp.user.permision.index') }}"><span class="lbl">Permision</span></a></li> --}}
                </ul>
            </li>
            
           
        </ul>
    </nav><!--.side-menu-->

@endsection

@section ('content')
    <div class="page-content">
        
        @yield ('page-content')
        
    </div>
@endsection




@section ('bottomjs')
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        @yield ('imageuploadjs')
        <script type="text/javascript" src="{{ asset ('public/user/js/lib/tether/tether.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset ('public/user/js/lib/bootstrap/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset ('public/user/js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ asset ('public/user/js/lib/lobipanel/lobipanel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset ('public/user/js/lib/match-height/jquery.matchHeight.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset ('public/user/js/lib/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="{{ asset ('public/user/js/lib/bootstrap-select/bootstrap-select.min.js')}}"></script>
        <script src="{{ asset ('public/user/js/lib/select2/select2.full.min.js')}}"></script>
       <script src="{{ asset ('public/user/js/lib/summernote/summernote.min.js') }}"></script>

       <script>
            $(document).ready(function() {
                $('.summernote').summernote();
            });
        </script>

        <script src="{{ asset ('public/user/js/app.js') }}"></script>
        <script src="{{ asset ('public/user/js/camcyber.js') }}"></script>
        @yield('appbottomjs')

        @if(Session::has('msg'))
        <script type="text/JavaScript">
            toastr.success("{!!Session::get('msg')!!}");
        </script>
        @endif
@endsection