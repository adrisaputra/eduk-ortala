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
					

					<form action="{{ url('/'.Request::segment(1).'/edit/'.$setting->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">		
					
					<div class="py-10">
						<h1 class="anchor fw-bolder mb-5" id="custom-form-control">
						<a href="#custom-form-control"></a>Ubah {{ __($title) }}</h1>
						<div class="py-5">
							<div class="rounded border p-10">

								<div class="mb-10">
									<label class="form-label required">{{ __('Nama Aplikasi') }}</label>
									<input type="text" class="form-control" placeholder="Nama Aplikasi" name="application_name" value="{{  $setting->application_name }}" />
									@if ($errors->has('application_name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('application_name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Singkatan Nama Aplikasi') }}</label>
									<input type="text" class="form-control" placeholder="Singkatan Nama Aplikasi" name="short_application_name" value="{{  $setting->short_application_name }}" />
									@if ($errors->has('short_application_name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('short_application_name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Logo Kecil ') }} </label>
									<input type="file" class="form-control" placeholder="Logo Kecil" name="small_icon" value="{{ $setting->small_icon }}" >
									<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
									@if($setting->small_icon)
										<img src="{{ asset('upload/setting/'.$setting->small_icon) }}" width="150px" height="150px">
									@endif
								</div>
								
								<div class="mb-10">
									<label class="form-label">{{ __('Logo Besar') }} </label>
									<input type="file" class="form-control" placeholder="Logo Besar" name="large_icon" value="{{ $setting->large_icon }}" >
									<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
									@if($setting->large_icon)
										<img src="{{ asset('upload/setting/'.$setting->large_icon) }}" width="150px" height="150px">
									@endif
								</div>
								
								<div class="mb-10">
									<label class="form-label">{{ __('Background Login') }} </label>
									<input type="file" class="form-control" placeholder="Background Login" name="background_login" value="{{ $setting->background_login }}" >
									<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span><br>
									@if($setting->background_login)
										<img src="{{ asset('upload/setting/'.$setting->background_login) }}" width="150px" height="150px">
									@endif
								</div>
								
								<div class="mb-10">
									<label class="form-label required">{{ __('Google Map Key') }}</label>
									<input type="text" class="form-control" placeholder="Google Map Key" name="gmaps_key" value="{{  $setting->gmaps_key }}" />
									@if ($errors->has('gmaps_key'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('gmaps_key') }}</div>
										</div>
									@endif
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