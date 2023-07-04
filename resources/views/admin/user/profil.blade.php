
@extends('admin/layout')
@section('konten')
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>{{ __($title)}}</h4>
                                    </div>                 
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
							<form action="{{ url('edit_profil/'.Crypt::encrypt($user->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="PUT">
									
							
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Pengguna') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
                                        	<input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ $user->name }}" >
                                        	<input type="hidden" class="form-control" placeholder="Nama User" name="name2" value="{{ $user->name }}" >
											@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Email') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="email" class="form-control" name="email" value="{{ $user->email }}">
											@if ($errors->has('email')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Foto User') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="file" class="form-control" placeholder="Foto" name="foto" value="{{ $user->foto }}" >
											<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 300 Kb (jpg,jpeg,png)</i></span>
											@if($user->foto)
												<br><img src="{{ asset('upload/foto/'.$user->foto) }}" width="150px" height="150px">
											@endif
											@if ($errors->has('foto')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('foto') }}</div>@endif
										</div>
									</div>
									
									<hr style="border-top: 1px solid #d4d8e0;">

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Password Lama') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="password" class="form-control" name="current-password">
											@if ($errors->has('current-password')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('current-password') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Password Baru') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="password" class="form-control" name="password">
											@if ($errors->has('password')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('password') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Konfirmasi Password') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="password" class="form-control" name="password_confirmation">
											@if ($errors->has('password_confirmation')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('password_confirmation') }}</div>@endif
										</div>
									</div>
									
									<button type="submit" class="btn btn-success">Simpan</button>
									<button type="reset" class="btn btn-warning">Reset</button>
								</form>	
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
@endsection