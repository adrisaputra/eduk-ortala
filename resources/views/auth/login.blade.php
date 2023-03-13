@extends('layouts.app')

@section('content')
@php
$setting = SiteHelpers::setting();
$slider = SiteHelpers::slider();
@endphp

<link href="{{ asset('assets/css/form-1.css') }}" rel="stylesheet" type="text/css" />

<div class="form-container">
    <div class="form-image">
        <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($slider as $i => $v)
                <div class="carousel-item @if($i==0) active @endif">
                    <img src="{{ asset('upload/slider/'.$v->image) }}" style="background-size: cover;background-position: center;width: 100%;height: 100%;">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                        <div class="text-center" style="margin-bottom:20px">
                            <img src="{{ asset('upload/setting/'.$setting->large_icon) }}" style="height: 50%;width:100%"  />
                        </div>
                        <form method="POST" action="{{ url('login_w') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            @if ($message = Session::get('status'))
                                <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 text-light">Gagal !</h4>
                                        <span>{{ $message }}</span>
                                    </div>
                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                        <span class="svg-icon svg-icon-2x svg-icon-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            @endif
                            
                            @if ($message = Session::get('status2'))
                                <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                        <h4 class="mb-2 text-light">Berhasil !</h4>
                                        <span>{{ $message }}</span>
                                    </div>
                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                        <span class="svg-icon svg-icon-2x svg-icon-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                @endif
                            
                            <div class="fv-row mb-10">
                                <label class="form-label fs-6 fw-bolder text-dark">Nama User</label>
                                <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Nama User" name="name" value="{{ old('name') }}" autocomplete="off" />
                            </div>
                            <div class="fv-row mb-10">
                                <div class="d-flex flex-stack mb-2">
                                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                </div>
                                <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">Continue</span>
                                </button>
                            </div>
                        </form>
                </div>                    
            </div>
        </div>
    </div>
</div>

@endsection