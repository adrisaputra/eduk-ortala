@extends('admin/layout')
@section('konten')
        <!--  BEGIN CONTENT AREA  -->
		<script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
							 			<h4>Ubah Data {{ __($title) }}</h4>
                                    </div>                 
                                </div>
                            </div>
					   
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">  
								<form action="{{ url('/'.Request::segment(1).'/edit/'.$setting->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="PUT">	

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Aplikasi') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control form-control-sm" placeholder="Nama Aplikasi" name="application_name" value="{{  $setting->application_name }}" />
											@if ($errors->has('application_name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('application_name') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Singkatan Nama Aplikasi') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
									<input type="text" class="form-control form-control-sm" placeholder="Singkatan Nama Aplikasi" name="short_application_name" value="{{  $setting->short_application_name }}" />
											@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Logo Kecil ') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="file" class="form-control form-control-sm" placeholder="Logo Kecil" name="small_icon" value="{{ $setting->small_icon }}" >
											<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
											@if($setting->small_icon)
												<img src="{{ asset('upload/setting/'.$setting->small_icon) }}" width="150px" height="150px">
											@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Logo Besar ') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="file" class="form-control form-control-sm" placeholder="Logo Besar" name="large_icon" value="{{ $setting->large_icon }}" >
											<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
											@if($setting->large_icon)
												<img src="{{ asset('upload/setting/'.$setting->large_icon) }}" width="150px" height="150px">
											@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Background Login') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="file" class="form-control form-control-sm" placeholder="Background Login" name="background_login" value="{{ $setting->background_login }}" >
											<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
											@if($setting->background_login)
												<img src="{{ asset('upload/setting/'.$setting->background_login) }}" width="150px" height="150px">
											@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Google Map Key') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control form-control-sm" placeholder="Google Map Key" name="gmaps_key" value="{{  $setting->gmaps_key }}" />
											@if ($errors->has('gmaps_key'))
												<div class="fv-plugins-message-container invalid-feedback">
													<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('gmaps_key') }}</div>
												</div>
											@endif
										</div>
									</div>

									
									<button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Simpan"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg></button>
									<button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Reset"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></button>
									<a href="{{ url(Request::segment(1)) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Kembali"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg></a>
								</form>	
                            </div>
                        </div>
                    </div>
                </div>

            </div>

@endsection