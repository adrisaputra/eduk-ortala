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
								<form action="{{ url(Request::segment(1).'/edit/'.Crypt::encrypt($employee->id)) }}" method="POST" enctype="multipart/form-data">
								{{ csrf_field() }}
                				<input type="hidden" name="_method" value="PUT">

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('NIP') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="nip" type="text" class="form-control"  value="{{ $employee->nip }}">
											@if ($errors->has('nip')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('nip') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Pegawai') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="name" type="text" class="form-control" value="{{ $employee->name }}" >
											@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Gelar Depan') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="front_title" value="{{ $employee->front_title }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Gelar Belakang') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="back_title" value="{{ $employee->back_title }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Tempat Lahir') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="birthplace" value="{{ $employee->birthplace }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Tanggal Lahir') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input name="date_of_birth" id="basicFlatpickr" value="{{ $employee->date_of_birth }}" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date..">
											@if ($errors->has('date_of_birth')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('date_of_birth') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Jenis Kelamin') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="gender">
												<option value="">- Pilih Jenis Kelamin -</option>
												<option value="LAKI-LAKI" @if($employee->gender=="LAKI-LAKI") selected @endif>Pria</option>
												<option value="PEREMPUAN" @if($employee->gender=="PEREMPUAN") selected @endif>Wanita</option>
											</select>
											@if ($errors->has('gender')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('gender') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Status') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="status">
												<option value="">- Pilih Status -</option>
												<option value="HONORER" @if($employee->status=="HONORER") selected @endif>HONORER</option>
												<option value="CPNS" @if($employee->status=="CPNS") selected @endif>CPNS</option>
												<option value="PNS" @if($employee->status=="PNS") selected @endif>PNS</option>
												<option value="PENSIUNAN" @if($employee->status=="PENSIUNAN") selected @endif>PENSIUNAN</option>
												<option value="ABRI" @if($employee->status=="ABRI") selected @endif>ABRI</option>
												<option value="BERHENTI" @if($employee->status=="BERHENTI") selected @endif>BERHENTI</option>
												<option value="MENINGGAL" @if($employee->status=="MENINGGAL") selected @endif>MENINGGAL</option>
												<option value="PERALIHAN" @if($employee->status=="PERALIHAN") selected @endif>PERALIHAN</option>
												<option value="PINDAH LUAR PROVINSI" @if($employee->status=="PINDAH LUAR PROVINSI") selected @endif>PINDAH LUAR PROVINSI</option>
											</select>
											@if ($errors->has('status')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('status') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Kategori Pegawai') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="employee_type">
												<option value="">- Pilih Kategori Pegawai -</option>
												<option value="ASN" @if($employee->employee_type=="ASN") selected @endif>ASN</option>
												<option value="PPPK" @if($employee->employee_type=="PPPK") selected @endif>PPPK</option>
											</select>
											@if ($errors->has('employee_type')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('employee_type') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Agama') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control" name="religion">
												<option value="">- Pilih Agama -</option>
												<option value="ISLAM" @if($employee->religion=="ISLAM") selected @endif>ISLAM</option>
												<option value="KATHOLIK" @if($employee->religion=="KATHOLIK") selected @endif>KATHOLIK</option>
												<option value="PROTESTAN" @if($employee->religion=="PROTESTAN") selected @endif>PROTESTAN</option>
												<option value="HINDU" @if($employee->religion=="HINDU") selected @endif>HINDU</option>
												<option value="BUDHA" @if($employee->religion=="BUDHA") selected @endif>BUDHA</option>
												<option value="SINTO" @if($employee->religion=="SINTO") selected @endif>SINTO</option>
												<option value="KONGHUCU" @if($employee->religion=="KONGHUCU") selected @endif>KONGHUCU</option>
												<option value="LAINNYA" @if($employee->religion=="LAINNYA") selected @endif>LAINNYA</option>
											</select>
											@if ($errors->has('religion')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('religion') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Alamat') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<textarea class="form-control" name="address">{{ $employee->address }}</textarea>
											@if ($errors->has('address')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('address') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('No. Karpeg') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="no_karpeg" value="{{ $employee->no_karpeg }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('No. Askes') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="no_askes" value="{{ $employee->no_askes }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('No. Taspen') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="no_taspen" value="{{ $employee->no_taspen }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('No. Karis/Karsu') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="no_karis_karsu" value="{{ $employee->no_karis_karsu }}" />
										</div>
									</div>

									<div class="form-group row mb-3">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('No. NPWP') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="no_npwp" value="{{ $employee->no_npwp }}" />
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

<script type="text/javascript">
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $(document).ready(function(){
     $( "#sel_emp" ).select2({
        ajax: { 
          url: "{{ route('getEducation') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
               _token: CSRF_TOKEN,
               search: params.term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

     })

   });
   </script>
@endsection