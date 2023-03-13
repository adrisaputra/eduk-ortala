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
        <form method="POST" action="{{ url('registrasi_w') }}">
            @csrf
               
                    @if ($message = Session::get('status'))
                        <p class="alert text-center" style="color: #ffffff;background-color: #dd4b39;border-color: #d73925;">
                            {{ $message }}
                        </p>
                    @endif

                    <div class="form-group has-feedback @if ($errors->has('name')) has-error @endif">
                        @if ($errors->has('name'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}</label>@endif
                        <input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ old('name') }}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback @if ($errors->has('email')) has-error @endif">
                        @if ($errors->has('email'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label>@endif
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
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
                            <button type="submit" class="btn btn-facebook btn-block btn-flat">Registrasi</button>
                        </div>
                    </div>
                </form>
                <!-- End Form Login -->

                <hr style="border: 0.5px dashed #d2d6de">
                
                <p><center>Sudah Punya Akun ? <a href="{{ url('/login')}}">Login Di Sini !!!</a></center></p>
            </div>
        </div>

@endsection