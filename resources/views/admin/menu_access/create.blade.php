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
					
					<form action="{{ url('/'.Request::segment(1).'/'.Crypt::encrypt($group->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					{{ csrf_field() }}
		
					<div class="py-10">
						<h1 class="anchor fw-border mb-5" id="custom-form-control">
						<a href="#custom-form-control"></a>Tambah {{ __($title) }}</h1>
						<div class="py-5">
							<div class="rounded border p-10">

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">Menu</label>
									<select class="form-select" aria-label="Select example" name="menu_id">
										<option value="">- Pilih Menu -</option>
										@foreach($menu as $v)
											<option value="{{ $v->id }}" @if(old('menu_id')==$v->id) selected @endif>{{ $v->menu_name }}</option>
										@endforeach
									</select>
									@if ($errors->has('menu_id'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('menu_id') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Create') }}</label>
									<select class="form-select" aria-label="Select example" name="create">
										<option value="">- Pilih -</option>
										<option value="1" @if(old('create')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('create')=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('create'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('create') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Read') }}</label>
									<select class="form-select" aria-label="Select example" name="read">
										<option value="">- Pilih -</option>
										<option value="1" @if(old('read')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('read')=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('read'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('read') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Update') }}</label>
									<select class="form-select" aria-label="Select example" name="update">
										<option value="">- Pilih -</option>
										<option value="1" @if(old('update')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('update')=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('update'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('update') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Delete') }}</label>
									<select class="form-select" aria-label="Select example" name="delete">
										<option value="">- Pilih -</option>
										<option value="1" @if(old('delete')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('delete')=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('delete'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('delete') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Print') }}</label>
									<select class="form-select" aria-label="Select example" name="print">
										<option value="">- Pilih -</option>
										<option value="1" @if(old('print')=="1") selected @endif>Aktif</option>
										<option value="0" @if(old('print')=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('print'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('print') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
									<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
									<a href="{{ url('/'.Request::segment(1).'/'.Crypt::encrypt($group->id)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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