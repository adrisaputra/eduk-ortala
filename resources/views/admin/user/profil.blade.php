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
					
					<form action="{{ url('/'.Request::segment(1).'/edit_profil/'.Crypt::encrypt($user->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">
		
					<div class="py-10">
						<h1 class="anchor fw-bolder mb-5" id="custom-form-control">
						<a href="#custom-form-control"></a>Ubah {{ __($title) }}</h1>
						<div class="py-5">
							<div class="rounded border p-10">

								<div class="mb-10">
									<label class="form-label required">{{ __('Nama User') }}</label>
									@if(Auth::user()->group_id==3)
										<input type="text" class="form-control" placeholder="Nama User" value="{{ $user->name }}" disabled>
										<input type="hidden" class="form-control" placeholder="Nama User" name="name" value="{{ $user->name }}" >
									@else
										<input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ $user->name }}" >
									@endif
									<input type="hidden" class="form-control" placeholder="Nama User" name="name2" value="{{ $user->name }}" >
									@if ($errors->has('name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Email') }}</label>
									<input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}" >
									@if ($errors->has('email'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('email') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Foto User ') }} </label>
									<input type="file" class="form-control" placeholder="Foto" name="foto" value="{{ $user->foto }}" >
									<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 300 Kb (jpg,jpeg,png)</i></span><br>
									@if($user->foto)
										<img src="{{ asset('upload/foto/'.$user->foto) }}" width="150px" height="150px">
									@endif
								</div>
								
								<div class="mb-10 fv-row" data-kt-password-meter="true">
									<div class="mb-1">
										<label class="form-label fw-bold fs-6 mb-2 required">{{ __('Password Lama') }}</label>
										<div class="position-relative mb-3">
											<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password" name="current-password" autocomplete="off" />
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
										@if ($errors->has('current-password'))
											<div class="fv-plugins-message-container invalid-feedback">
												<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('current-password') }}</div>
											</div>
										@endif
									</div>
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
										@if ($errors->has('password'))
											<div class="fv-plugins-message-container invalid-feedback">
												<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('password') }}</div>
											</div>
										@endif
									</div>
								</div>

								<div class="mb-10 fv-row" data-kt-password-meter="true">
									<div class="mb-1">
										<label class="form-label fw-bold fs-6 mb-2 required">{{ __('Konfirmasi Password') }}</label>
										<div class="position-relative mb-3">
											<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Konfirmasi Password" name="password_confirmation" autocomplete="off" />
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
										</div>
										@if ($errors->has('password'))
											<div class="fv-plugins-message-container invalid-feedback">
												<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('password') }}</div>
											</div>
										@endif
									</div>
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