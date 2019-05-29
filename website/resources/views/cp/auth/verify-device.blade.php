@extends('cp/layouts.auth')
@section('title', 'Verify Code')


@section('pagecontent')
    <?php if (session('flashmessage')) : ?>
    <div style="max-width: 322px; margin: 0 auto">
    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{ session('flashmessage') }}
    </div>  
    </div>
    <?php endif; ?>

    @if ($errors->has('code'))
        <div style="max-width: 322px; margin: 0 auto">
            <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ $errors->first('code') }}
            </div>  
        </div>
    <?php endif; ?>

    <form action="{{ route('cp.auth.submit-code') }}" method="POST" class="sign-box" id="form-signin_v1" name="form-signin_v1" method="POST" >
        <div class="sign-avatar">
            <img src="{{ asset ('public/user/img/logo.png') }}" alt="">
        </div>
        <header class="sign-title">Verify Code</header>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <input  type="text" 
                    value ="" 
                    class="form-control" 
                    placeholder="Enter Code"
                    required
                    name="code" />
        </div>
        
        
        <button type="submit" class="btn btn-inline">Submit</button>
        
    </form>
    
@endsection
