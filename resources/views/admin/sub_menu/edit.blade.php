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
					
					<form action="{{ url('/'.Request::segment(1).'/edit/'.Crypt::encrypt($menu->id).'/'.Crypt::encrypt($sub_menu->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">
		
					<div class="py-10">
						<h1 class="anchor fw-border mb-5" id="custom-form-control">
						<a href="#custom-form-control"></a>Ubah {{ __($title) }}</h1>
						<div class="py-5">
							<div class="rounded border p-10">

								<div class="mb-10">
									<label class="form-label">{{ __('Nama Menu') }}</label>
									<input type="text" class="form-control" placeholder="Nama Menu" name="menu_name" value="{{ $menu->menu_name }}" disabled>
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Nama Sub Menu') }}</label>
									<input type="text" class="form-control" placeholder="Nama Sub Menu" name="sub_menu_name" value="{{ $sub_menu->sub_menu_name }}" />
									@if ($errors->has('sub_menu_name'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('sub_menu_name') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Link') }}</label>
									<input type="text" class="form-control" placeholder="Link" name="link" value="{{ $sub_menu->link }}" />
									@if ($errors->has('link'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('link') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Atribute') }}</label>
									<input type="text" class="form-control" placeholder="Atribute" name="attribute" value="{{ $sub_menu->attribute }}" />
								</div>

								<div class="mb-10">
									<label class="form-label required">{{ __('Posisi') }}</label>
									<input type="text" class="form-control" placeholder="Posisi" name="position" value="{{ $sub_menu->position }}" />
									@if ($errors->has('position'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('position') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<label class="form-label">{{ __('Deskripsi') }}</label>
									<input type="text" class="form-control" placeholder="Deskripsi" name="desc" value="{{ $sub_menu->desc }}" />
								</div>

								<div class="mb-10">
									<label for="exampleFormControlInput1" class="form-label required">{{ __('Status') }}</label>
									<select class="form-select" aria-label="Select example" name="status">
										<option value="">- Pilih Status -</option>
										<option value="1" @if($sub_menu->status=="1") selected @endif>Aktif</option>
										<option value="0" @if($sub_menu->status=="0") selected @endif>Tidak Aktif</option>
									</select>
									@if ($errors->has('status'))
										<div class="fv-plugins-message-container invalid-feedback">
											<div data-field="email_input" data-validator="notEmpty">{{ $errors->first('status') }}</div>
										</div>
									@endif
								</div>

								<div class="mb-10">
									<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
									<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
									<a href="{{ url('/'.Request::segment(1).'/'.Crypt::encrypt($menu->id)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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