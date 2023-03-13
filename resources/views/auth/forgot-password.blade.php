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
                <form method="POST" action="{{ route('password.email') }}">
                @csrf
               
                    @if (session('status'))
                        <p class="alert text-center" style="color: #ffffff;background-color: #00a65a;border-color: #00a65a;">
                            {{ session('status') }}
                        </p>
                    @endif

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <hr style="border: 0.5px dashed #d2d6de">
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-facebook btn-block btn-flat">Reset</button>
                        </div>
                    </div>
                </form>
                <!-- End Form Login -->

                <hr style="border: 0.5px dashed #d2d6de">
                
                <p><center><a href="{{ url('/')}}">Login</a></center></p>
            </div>
        </div>

@endsection