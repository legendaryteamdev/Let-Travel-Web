@extends('cp/layouts.auth')

@section('title', 'Login')

@section('pagecontent')


    <form action="{{ route('cp.auth.authenticate') }}" method="POST" class="sign-box" id="form-signin_v1" name="form-signin_v1" method="POST" >
        <div class="sign-avatar">
            <img src="{{ asset ('public/user/img/logo.png') }}" alt="">
        </div>
        <header class="sign-title">Access Denied!</header>
        
     
        <div class="form-group">
           <p class="text-center"> You are not allowed to access the system using your internet. Please contact your admin for the permission!</p>
        </div>
       
        <a href="{{ url('') }}" class="btn btn-inline">Back To Homepage</a>
        
    </form>
@endsection
