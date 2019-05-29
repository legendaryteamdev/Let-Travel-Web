@extends('cp/layouts.master')

@section('headercss')
    <link rel="stylesheet" href="{{ asset('public/user/css/lib/font-awesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/user/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('content')
<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
        @yield('pagecontent')
        </div>
    </div>
</div>
@endsection


@section('bottomjs')
<script src="{{ asset ('public/user/js/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset ('public/user/js/lib/tether/tether.min.js') }}"></script>
<script src="{{ asset ('public/user/js/lib/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset ('public/user/js/plugins.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset ('public/user/js/app.js') }}"></script>
@if(Session::has('msg'))
<script type="text/JavaScript">
    toastr.error("{!!Session::get('msg')!!}");
</script>
@endif
@yield('appbottomjs')

@endsection