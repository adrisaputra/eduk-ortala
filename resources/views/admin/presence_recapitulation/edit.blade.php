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
										@if(Auth::user()->group_id==1)
                                        	<h4>Ubah {{ __($title) }}</h4>
										@else
                                        	<h4>{{ __(Auth::user()->parent_unit->name) }}</h4>
										@endif
                                    </div>                    
                                </div>
                            </div>
                            
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
								<form action="{{ url('/'.Request::segment(1).'/edit/'.Request::segment(3)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="PUT">
		
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-lg-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Tanggal') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<input name="date" id="basicFlatpickr" value="{{ $presence_recapitulation->date }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal">
											@if ($errors->has('date')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('date') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-4 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Jumlah ASN') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
                                            <input type="number" class="form-control" name="employee_amount" value="{{ $presence_recapitulation->employee_amount }}" >
                                       		@if ($errors->has('employee_amount')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('employee_amount') }}</div>@endif
										</div>
									</div>
									
									<hr>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Tugas Luar') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<input type="number" class="form-control" name="tl" value="{{ $presence_recapitulation->tl }}" >
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Cuti') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<input type="number" class="form-control" name="ct" value="{{ $presence_recapitulation->ct }}" >
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Sakit') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<input type="number" class="form-control" name="s" value="{{ $presence_recapitulation->s }}" >
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Tanpa Keterangan') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<input type="number" class="form-control" name="th" value="{{ $presence_recapitulation->th }}" >
										</div>
									</div>

									<hr>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-5 col-form-label" style="color: #000000;font-weight:bold;">{{ __('Keterangan') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10 col-7">
											<textarea class="form-control" name="desc" >{{ $presence_recapitulation->desc }}</textarea>
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