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
                                        <h4>Tambah {{ __($title) }}</h4>
                                    </div>                 
                                </div>
                            </div>
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
							<form action="{{ url('/'.Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
									{{ csrf_field() }}
									
									<div class="form-group row mb-2">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama Pegawai') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control basic" name="employee_id" id="employee_id" onchange="getClass()">
												<option value="">- Pilih Pegawai -</option>
												@foreach($employee as $v)
													<option value="{{ $v->id }}" @if(old('employee_id')==$v->id) selected @endif>{{ $v->nip}} || {{ $v->front_title }} {{ $v->name }} {{ $v->back_title }}</option>
												@endforeach
											</select>
											@if ($errors->has('employee_id')) <div class="invalid-feedback" style="display: block;margin-top: -20px;">{{ $errors->first('employee_id') }}</div>@endif
										</div>
									</div>
									
									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Pangkat Lama') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="last_promotion" id="last_promotion" value="{{ old('last_promotion') }}" readonly/>
											@if ($errors->has('last_promotion')) <div class="invalid-feedback" style="display: block;margin-top: -20px;">{{ $errors->first('last_promotion') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-4">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Pangkat Baru') }}</label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<input type="text" class="form-control" name="new_promotion" id="new_promotion" value="{{ old('new_promotion') }}" readonly/>
											@if ($errors->has('new_promotion')) <div class="invalid-feedback" style="display: block;margin-top: -20px;">{{ $errors->first('new_promotion') }}</div>@endif
										</div>
									</div>

									<div class="form-group row mb-2">
										<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Jenis Kenaikan') }}  <span class="required" style="color: #dd4b39;">*</span></label>
										<div class="col-xl-9 col-lg-9 col-sm-10">
											<select class="form-control basic" name="promotion_type">
												<option value="">- Pilih Jenis Kenaikan -</option>
												<option value="Pejabat Negara" @if(old('promotion_type')=="Pejabat Negara") selected @endif>Pejabat Negara</option>
												<option value="Prestasi Luar Biasa" @if(old('promotion_type')=="Prestasi Luar Biasa") selected @endif>Prestasi Luar Biasa</option>
												<option value="Penyesuaian Ijazah" @if(old('promotion_type')=="Penyesuaian Ijazah") selected @endif>Penyesuaian Ijazah</option>
												<option value="Jabatan Fungsional Tertentu" @if(old('promotion_type')=="Jabatan Fungsional Tertentu") selected @endif>Jabatan Fungsional Tertentu</option>
												<option value="Jabatan Struktural" @if(old('promotion_type')=="Jabatan Struktural") selected @endif>Jabatan Struktural</option>
												<option value="Reguler" @if(old('promotion_type')=="Reguler") selected @endif>Reguler</option>
											</select>
										@if ($errors->has('promotion_type')) <div class="invalid-feedback" style="display: block;margin-top: -20px;">{{ $errors->first('promotion_type') }}</div>@endif
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
<script>		
	function getClass(){
		employee_id = document.getElementById('employee_id').value;
		url = "{{ url('/employee/get_class') }}"
		$.ajax({
			url:""+url+"/"+employee_id+"",
			success : function(response){
				// $("#hasil").html(response);
				document.getElementById('last_promotion').value = response.last_promotion;
				document.getElementById('new_promotion').value = response.new_promotion;
			}
		})
	}
</script>		
@endsection