@extends('admin.layout')
@section('konten')

@include('admin.toolbar')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
	<!--begin::Container-->
	<div id="kt_content_container" class="container-xxl">
		<!--begin::Card-->
		<div class="card">
			<!--begin::Card body-->
			<div class="card-body pt-0">
					<!--begin::Section-->
					
					<form action="{{ url('/'.Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					{{ csrf_field() }}

					<div class="py-10">
						<h1 class="anchor fw-bolder mb-5" id="custom-form-control">
						<a href="#custom-form-control"></a>Tambah {{ __($title) }}</h1>
						<div class="py-5">
							<div class="rounded border p-10">
							<div class="row g-5 g-xl-8">

								<div class="col-xl-6">
									<label class="form-label required">{{ __('NIP') }}</label>
									<input type="text" class="form-control" placeholder="NIP" name="nip" value="{{ old('nip') }}" />
									@if ($errors->has('nip'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('nip') }}</div>
										</div>
									@endif
								</div>

								<div class="col-xl-6">
									<label class="form-label required">{{ __('Nama Pegawai') }}</label>
									<input type="text" class="form-control" placeholder="Nama Pegawai" name="name" value="{{ old('name') }}" />
									@if ($errors->has('name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('name') }}</div>
										</div>
									@endif
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Gelar Depan') }}</label>
									<input type="text" class="form-control" placeholder="Gelar Depan" name="front_title" value="{{ old('front_title') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Gelar Belakang') }}</label>
									<input type="text" class="form-control" placeholder="Gelar Belakang" name="back_title" value="{{ old('back_title') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Tempat Lahir') }}</label>
									<input type="text" class="form-control" placeholder="Tempat Lahir" name="birthplace" value="{{ old('birthplace') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Tanggal Lahir') }}</label>
									<input type="text" class="form-control" placeholder="Tanggal Lahir" name="date_of_birth" value="{{ old('date_of_birth') }}" id="kt_daterangepicker_3"/>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Status Pegawai') }}</label>
									<select class="form-select" aria-label="Select example" name="status">
										<option value="">- Pilih Status Pegawai -</option>
										<option value="pns" @if(old('status')=="pns") selected @endif>PNS</option>
										<option value="cpns" @if(old('status')=="cpns") selected @endif>CPNS</option>
										<option value="honorer" @if(old('status')=="honorer") selected @endif>Honorer</option>
									</select>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Jenis Pegawai') }}</label>
									<select class="form-select" aria-label="Select example" name="employee_type">
										<option value="">- Pilih Jenis Pegawai -</option>
										<option value="ASN" @if(old('employee_type')=="ASN") selected @endif>ASN</option>
										<option value="PPPK" @if(old('employee_type')=="PPPK") selected @endif>PPPK</option>
									</select>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Agama') }}</label>
									<select class="form-select" aria-label="Select example" name="religion">
										<option value="">- Pilih Agama -</option>
										<option value="Islam" @if(old('religion')=="Islam") selected @endif> Islam</option>
										<option value="Katolik" @if(old('religion')=="Katolik") selected @endif> Katolik</option>
										<option value="Hindu" @if(old('religion')=="Hindu") selected @endif> Hindu</option>
										<option value="Budha" @if(old('religion')=="Budha") selected @endif> Budha</option>
										<option value="Sinto" @if(old('religion')=="Sinto") selected @endif> Sinto</option>
										<option value="Konghucu" @if(old('religion')=="Konghucu") selected @endif> Konghucu</option>
										<option value="Protestan" @if(old('religion')=="Protestan") selected @endif> Protestan</option>
									</select>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Tempat Lahir') }}</label>
									<input type="text" class="form-control" placeholder="Tempat Lahir" name="address" value="{{ old('address') }}" />
								</div>

								<hr>

								<div class="col-xl-6">
									<label class="form-label">{{ __('No. Karpeg') }}</label>
									<input type="text" class="form-control" placeholder="No. Karpeg" name="no_karpeg" value="{{ old('no_karpeg') }}" />
								</div>
	
								<div class="col-xl-6">
									<label class="form-label">{{ __('No. Askes') }}</label>
									<input type="text" class="form-control" placeholder="No. Askes" name="no_askes" value="{{ old('no_askes') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('No. Taspen') }}</label>
									<input type="text" class="form-control" placeholder="No. Taspen" name="no_taspen" value="{{ old('no_taspen') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('No. Karis/Karsu') }}</label>
									<input type="text" class="form-control" placeholder="No. Karis/Karsu" name="no_karis_karsu" value="{{ old('no_karis_karsu') }}" />
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('No. NPWP') }}</label>
									<input type="text" class="form-control" placeholder="No. NPWP" name="no_npwp" value="{{ old('no_npwp') }}" />
								</div>

								<div class="col-xl-6">
								</div>

								<hr>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Golongan') }}</label>
									<select class="form-select" aria-label="Select example" name="class_id">
										<option value="">- Pilih Golongan -</option>
										@foreach($class as $v)
											<option value="{{ $v->id }}" @if(old('class_id')==$v->id) selected @endif>{{ $v->class_id}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Jabatan') }}</label>
									<select class="form-select" aria-label="Select example" name="position_id">
										<option value="">- Pilih Jabatan -</option>
										@foreach($position as $v)
											<option value="{{ $v->id }}" @if(old('position_id')==$v->id) selected @endif>{{ $v->class}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-xl-6">
									<label class="form-label">{{ __('Pendidikan') }}</label>
									<select class="form-select" aria-label="Select example" name="education_id">
										<option value="">- Pilih Pendidikan -</option>
										@foreach($education as $v)
											<option value="{{ $v->id }}" @if(old('education_id')==$v->id) selected @endif>{{ $v->name}}</option>
										@endforeach
									</select>
								</div>


								<div class="col-xl-6">
									<label class="form-label">{{ __('Unor') }}</label>
									<select class="form-select" aria-label="Select example" name="unit_id">
										<option value="">- Pilih Unor -</option>
										@foreach($unit as $v)
											<option value="{{ $v->id }}" @if(old('unit_id')==$v->id) selected @endif>{{ $v->name}}</option>
										@endforeach
									</select>
								</div>

								<div class="mb-10">
									<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
									<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
									<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
								</div>
								</div>

							</div>
						</div>
					</div>
				</form>
				<!--end::Section-->
			</div>
			<!--end::Card body-->
		</div>
		<!--end::Card-->
	</div>
	<!--end::Container-->
</div>
<!--end::Post-->
</div>
<!--end::Content-->

<script>
	$("#kt_daterangepicker_3").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1900,
        maxYear: parseInt(moment().format("YYYY"),10)
    }
);
</script>
@endsection