@extends('cp/layouts.auth')

@section('title', 'Reset Password For User')

@section('pagecontent')
   @if (session('status'))
        <div style="max-width: 322px; margin: 0 auto">
            <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ session('status') }}
            </div>  
        </div>
    @endif
    @if ($errors->any())
        <div style="max-width: 322px; margin: 0 auto">
            <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>{{$errors->first()}}</strong>
            </div>  
        </div>
    @endif
    <form action="{{ route('cp.auth.make-forgot-password-code') }}" method="POST" class="sign-box" id="form-signin_v1" name="form-signin_v1" method="POST" >
        <div class="sign-avatar">
            <img src="{{ asset ('public/user/img/logo.png') }}" alt="">
        </div>
        <header class="sign-title">Reset Password For User</header>
        {{ csrf_field() }}
        
        <div class="form-group">
            <input  type="email" 
                    value ="{{ old('email') }}" 
                    class="form-control" 
                    placeholder="Enter Email or Phone Number"
                    required
                    name="email" 
                     />
        </div>
       
        <div class="form-group">
            <div class="checkbox float-left">
                
            </div>
            <div class="float-right reset">
                <a href="{{ route('cp.auth.login') }}">Back To Log In</a>
            </div>
        </div>
        <button type="submit" class="btn btn-inline">Get Code!</button>
    </form>
@endsection

