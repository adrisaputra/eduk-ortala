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
									<label class="form-label required">{{ __('Kode Unor') }}</label>
									<input type="text" class="form-control" placeholder="Kode Unor" name="code" value="{{ old('code') }}" />
									@if ($errors->has('code'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('code') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Nama Unor') }}</label>
									<input type="text" class="form-control" placeholder="Nama Unor" name="name" value="{{ old('name') }}" />
									@if ($errors->has('name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label">{{ __('Unor Induk') }}</label>
									<select class="form-select" aria-label="Select example" name="parent_code">
										<option value="">- Pilih Unor Induk -</option>
										@foreach($get_unit as $v)
											<option value="{{ $v->code }}" @if(old('parent_code')==$v->code) selected @endif>{{ $v->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label">{{ __('Unor Atasan') }}</label>
									<select class="form-select" aria-label="Select example" name="leader_code">
										<option value="">- Pilih Unor Atasan -</option>
										@foreach($get_unit as $v)
											<option value="{{ $v->code }}" @if(old('leader_code')==$v->code) selected @endif>{{ $v->name }}</option>
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