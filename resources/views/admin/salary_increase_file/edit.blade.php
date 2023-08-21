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
                                        <h4>Ubah {{ __($title) }}</h4>
                                    </div>                 
                                </div>
                            </div>
                            
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
								<form action="{{ url(Request::segment(1).'/edit/'.Request::segment(3).'/'.Crypt::encrypt($salary_increase_file->id)) }}" method="POST" enctype="multipart/form-data">
								{{ csrf_field() }}
                				<input type="hidden" name="_method" value="PUT">

		
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama File') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
                                            <input type="text" class="form-control" placeholder="Nama File" name="name" value="{{ $salary_increase_file->name }}" >
                                       		@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('File') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="file" class="form-control" name="file" value="{{ old('file') }}">
											<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 10 Mb (jpg,jpeg,png,dan pdf)</i></span><br>
											@if ($errors->has('file')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('file') }}</div>@endif
											@if($salary_increase_file->file)
											<a href="{{ asset('upload/salary_increase_file/'.$salary_increase_file->file) }}" target="_blank" class="btn mb-2 mr-1 btn-info">Download File</a>
											@endif
										</div>
									</div>
									
									<button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Simpan"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg></button>
									<button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Reset"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></button>
									<a href="{{ url(Request::segment(1).'/'.Request::segment(3)) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Kembali"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg></a>
								</form>	
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>			
@endsection