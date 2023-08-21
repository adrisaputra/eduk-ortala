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
								<form action="{{ url('/'.Request::segment(1).'/edit/'.Crypt::encrypt($salary_increase->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="PUT">
		
								<div class="form-group row mb-2" style="margin-bottom: 0rem!important;">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Pegawai') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control basic" name="employee_id" id="employee_id" onchange="getClass()">
												<option value="">- Pilih Pegawai -</option>
												@foreach($employee as $v)
													<option value="{{ $v->id }}" @if($salary_increase->employee_id==$v->id) selected @endif>{{ $v->nip}} || {{ $v->front_title }} {{ $v->name }} {{ $v->back_title }}</option>
												@endforeach
											</select>
											@if ($errors->has('employee_id')) <div class="invalid-feedback" style="display: block;margin-top: -20px;">{{ $errors->first('employee_id') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Gaji Lama') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="old_salary" value="{{ number_format($salary_increase->old_salary, 0, ',', '.') }}" type="text" onkeyup="formatRupiah(this, '.')" class="form-control form-control-sm">
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Pejabat Yang Menetapkan') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="placeman" id="placeman" value="{{ $salary_increase->placeman }}"/>
											</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Tanggal SK') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="sk_date" value="{{ $salary_increase->sk_date }}" id="basicFlatpickr" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal">
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nomor SK') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="sk_number" id="sk_number" value="{{ $salary_increase->sk_number }}"/>
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Tanggal Mulai Berlaku Gaji Tersebut') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="start_old_date" value="{{ $salary_increase->start_old_date }}" id="basicFlatpickr2" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal">
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Masa Kerja') }}</label>
										<div class="col-xl-3 col-lg-3 col-sm-10">
											<input type="text" class="form-control" name="year_old_salary" id="year_old_salary" value="{{ $salary_increase->year_old_salary }}" placeholder="Tahun"/>
										</div>
										<div class="col-xl-3 col-lg-3 col-sm-10">
											<input type="text" class="form-control" name="month_old_salary" id="month_old_salary" value="{{ $salary_increase->month_old_salary }}" placeholder="Bulan"/>
										</div>
									</div>

									<hr>
	
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Gaji Pokok Baru') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="new_salary" value="{{ number_format($salary_increase->new_salary, 0, ',', '.') }}" type="text" onkeyup="formatRupiah(this, '.')" class="form-control form-control-sm">
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Masa Kerja') }}</label>
										<div class="col-xl-3 col-lg-3 col-sm-10">
											<input type="text" class="form-control" name="year_new_salary" id="year_new_salary" value="{{ $salary_increase->year_new_salary }}" placeholder="Tahun"/>
										</div>
										<div class="col-xl-3 col-lg-3 col-sm-10">
											<input type="text" class="form-control" name="month_new_salary" id="month_new_salary" value="{{ $salary_increase->month_new_salary }}" placeholder="Bulan"/>
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Dalam Golongan') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="class" id="class" value="{{ $salary_increase->class }}"/>
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Mulai Tanggal') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="start_new_date" value="{{ $salary_increase->start_new_date }}" id="basicFlatpickr3" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal">
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Status Pegawai') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="status_employee" id="status_employee" value="Pegawai Negeri Sipil Daerah" readonly/>
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('KGB Berikutnya') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="next_kgb" value="{{ $salary_increase->next_kgb }}" id="basicFlatpickr4" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal">
										</div>
									</div>
									
									<button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Simpan"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg></button>
									<button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Reset"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></button>
									<a href="{{ url('salary_increase') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Kembali"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg></a>
								</form>	
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>	
@endsection