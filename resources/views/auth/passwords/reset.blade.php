@extends('layouts.app')

@section('content')
@php
    $setting = SiteHelpers::setting();
@endphp
<div class="login-box">
            <div class="login-box-body">
                <div class="text-center">
                    <img src="{{ asset('upload/setting/'.$setting->large_icon) }}" alt="Chris Wood" class="img-fluid" style="height: 80px;max-width: 100%;max-height: 100%;" >
                </div><br>
                <!-- Start Form Login -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

               
                    @if (session('status'))
                        <p class="alert text-center" style="color: #ffffff;background-color: #00a65a;border-color: #00a65a;">
                            {{ session('status') }}
                        </p>
                    @endif

                    <div class="form-group has-feedback @if ($errors->has('email')) has-error @endif">
                        @if ($errors->has('email'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label>@endif
                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ $email ?? old('email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback @if ($errors->has('password')) has-error @endif">
                        @if ($errors->has('password'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}</label>@endif
                        <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Konfirmasi Password" name="password_confirmation" required autocomplete="current-password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <hr style="border: 0.5px dashed #d2d6de">
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-facebook btn-block btn-flat">Reset Password</button>
                        </div>
                    </div>
                </form>
                <!-- End Form Login -->

                <hr style="border: 0.5px dashed #d2d6de">
                
            </div>
        </div>

@endsection