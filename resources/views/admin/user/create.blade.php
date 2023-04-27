<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="{{ url('/'.Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			{{ csrf_field() }}
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Tambah Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Nama') }}</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-sm" placeholder="">
						@if ($errors->has('name')) <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>@endif
					</div>
				</div>
				
				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Alamat Email') }}</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<input name="email" value="{{ old('email') }}" type="email" class="form-control form-control-sm" placeholder="">
						@if ($errors->has('email'))<div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>@endif
					</div>
				</div>
				
				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Password') }}</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<input name="password" value="{{ old('password') }}" type="password" class="form-control form-control-sm" placeholder="">
						@if ($errors->has('password'))<div class="invalid-feedback" style="display: block;">{{ $errors->first('password') }}</div>@endif
					</div>
				</div>

				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{ __('Konfirmasi Password') }}</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<input name="password_confirmation" value="{{ old('password') }}" type="password" class="form-control form-control-sm" placeholder="">
					</div>
				</div>

				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">Group</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<select class="form-control form-control-sm" name="group_id">
							<option value="">- Pilih Group -</option>
							@foreach($group as $v)
								<option value="{{ $v->id }}" @if(old('group_id')=="$v->id") selected @endif>{{ $v->group_name }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group row mb-4">
					<label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">Status</label>
					<div class="col-xl-9 col-lg-9 col-sm-10">
						<select class="form-control form-control-sm" name="status">
							<option value="">- Pilih Status -</option>
							<option value="1" @if(old('status')=="1") selected @endif>Aktif</option>
							<option value="0" @if(old('status')=="0") selected @endif>Tidak Aktif</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>