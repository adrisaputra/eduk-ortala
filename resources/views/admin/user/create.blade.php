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

								<div class="mb-10">
									<label class="form-label required">{{ __('Nama User') }}</label>
									<input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ old('name') }}" />
									@if ($errors->has('name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Email') }}</label>
									<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" >
									@if ($errors->has('email'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('email') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10 fv-row" data-kt-password-meter="true">
									<div class="mb-1">
										<label class="form-label fw-bold fs-6 mb-2 required">{{ __('Password Baru') }}</label>
										<div class="position-relative mb-3">
											<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password" name="password" autocomplete="off" />
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
										</div>
										<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
										@if ($errors->has('password'))
											<div class="fv-plugins-message-container invalid-feedback">
												<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('password') }}</div>
											</div>
										@endif
									</div>
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Konfirmasi Password') }}</label>
									<input type="password" class="form-control" placeholder="Konfirmasi Password" name="password_confirmation" >
								</div>
								
								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Group') }}</label>
									<select class="form-select" aria-label="Select example" name="group_id" onchange=" if (this.selectedIndex==2){ 
												document.getElementById('office').style.display = 'inline'; 
											} else {
												document.getElementById('office').style.display = 'none'; 
											} ;">
										<option value="">- Pilih Group -</option>
										@foreach($group as $v)
											<option value="{{ $v->id }}" @if(old('group_id')=="$v->id") selected @endif>{{ $v->group_name }}</option>
										@endforeach
									</select>
									@if ($errors->has('group_id'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('group_id') }}</div>
										</div>
									@endif
								</div>

								@if(old('group_id') =="2" )
									<span id="office" style="display:inline;">
								@else
									<span id="office" style="display:none;">
								@endif
									<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('OPD') }}</label>
									<select class="form-select form-select-solid" data-control="select2"  aria-label="Select example" name="office_id" data-placeholder="Select an option" data-allow-clear="true" >
										<option value="">- Pilih OPD -</option>
										@foreach($office as $v)
											<option value="{{ $v->id }}" @if(old('office_id')=="$v->id") selected @endif>{{ $v->office_name }}</option>
										@endforeach
									</select>
									@if ($errors->has('office_id'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('office_id') }}</div>
										</div>
									@endif
								</div>
								</span>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label">{{ __('Status') }}</label>
									<select class="form-select" aria-label="Select example" name="status">
										<option value="">- Pilih Status -</option>
										<option value="1" @if(old('status')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('status')=="0") selected @endif>Tidak Aktif</option>
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
@endsection