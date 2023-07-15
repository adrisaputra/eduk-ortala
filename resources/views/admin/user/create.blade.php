@extends('admin.layout')
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
							<form action="{{ url('/'.Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
									{{ csrf_field() }}
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Pengguna') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
                                            <input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ old('name') }}" >
                                       		@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Email') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="email" class="form-control" name="email" value="{{ old('email') }}">
											@if ($errors->has('email')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Password') }}  <span class="required" style="color: #dd4b39;">*</span></label>
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
											
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Group') }}<span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="group_id" onchange=" if (this.selectedIndex==1){ 
												document.getElementById('parent_unit').style.display = 'none'; 
											} else if (this.selectedIndex==2){
												document.getElementById('parent_unit').style.display = 'inline'; 
											};">
												<option value="">- Pilih Group -</option>
												@foreach($group as $v)
													<option value="{{ $v->id }}" @if(old('group_id')=="$v->id") selected @endif>{{ $v->group_name }}</option>
												@endforeach
											</select>
											@if ($errors->has('group_id')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('group_id') }}</div>@endif
										</div>
									</div>
									
									<span id="parent_unit" style="display:none;">
										<div class="form-group row mb-4">
											<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Unor Induk') }}<span class="required" style="color: #dd4b39;">*</span></label>
											<div class="col-xl-9 col-lg-9 col-sm-10">
												<select class="form-control" name="parent_unit_id">
													<option value="">- Pilih Unor Induk -</option>
													@foreach($parent_unit as $v)
														<option value="{{ $v->id }}" @if(old('parent_unit_id')=="$v->id") selected @endif>{{ $v->name }}</option>
													@endforeach
												</select>
												@if ($errors->has('parent_unit_id')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('parent_unit_id') }}</div>@endif
											</div>
										</div>
									</span>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Status') }}<span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="status">
												<option value="0" @if(old('status')=="0") selected @endif>Tidak Aktif</option>
												<option value="1" @if(old('status')=="1") selected @endif>Aktif</option>
											</select>
											@if ($errors->has('status')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('status') }}</div>@endif
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
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>			
@endsection