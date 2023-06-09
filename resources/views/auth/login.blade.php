@extends('layouts.app')

@section('content')
@php
$setting = SiteHelpers::setting();
@endphp
<div class="form-container outer" style="background-image: url({{ asset('upload/setting/'.$setting->background_login) }});background-size: cover;">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <div class="text-center">
                            <img src="{{ asset('upload/setting/'.$setting->large_icon) }}" style="width:90%"  />
                        </div>
                        
                        <form  class="text-left" method="POST" action="{{ url('login_w') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form">
                                <br>
                                @if ($message = Session::get('status'))
                                    <div class="alert alert-success mb-4" role="alert" style="margin-bottom: 0.5rem!important;"> 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button> 
                                        {{ $message }} 
                                    </div>
                                @elseif ($message = Session::get('status2'))
                                    <div class="alert alert-danger mb-4" role="alert" style="margin-bottom: 0.5rem!important;"> 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button> 
                                        {{ $message }} 
                                    </div>
                                @endif
                                
                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">EMAIL</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="email" type="text" class="form-control" placeholder="Masukkan Email">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <label for="password">PASSWORD</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="username-field" class="field-wrapper input">
                                            <label for="username"><?=captcha_img('flat');?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="field-wrapper input">
                                            <input id="username" name="captcha" type="text" class="form-control" placeholder="Masukkan Captcha" style="padding: 13px 15px 13px 15px;">
                                            @if ($errors->has('captcha')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('captcha') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                </div>
                                

                                <p class="signup-link"></p>

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection