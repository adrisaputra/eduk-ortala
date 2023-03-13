@extends('layouts.app')

@section('content')
@php
    $setting = SiteHelpers::setting();
@endphp
<div class="login-box">
            <div class="login-box-body">
                <!-- Start Form Login -->
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <center>{{ __('Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.') }}
                    {{ __('Jika Anda tidak menerima email, silahkan klik link dibawah ini') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik di sini untuk mengirim ulang tautan verifikasi') }}</button>.
                    </form>
                <!-- End Form Login -->

                <hr style="border: 0.5px dashed #d2d6de">
            </div>
        </div>

@endsection