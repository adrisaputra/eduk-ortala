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
			
			<!--begin::Card header-->
			<div class="card-header border-0 pt-6" style="min-height: 10px;">
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body pt-0">
				
				<!--begin::Alert-->
				@if ($message = Session::get('status'))
				<div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row w-100 p-5">
					<div class="d-flex flex-column text-light pe-0 pe-sm-10">
						<h4 class="mb-2 text-light">
						<i class="icon fa fa-check" style="color:white"></i> Berhasil !</h4>
						<span>{{ $message }}</span>
					</div>
					<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
						<span class="svg-icon svg-icon-2x svg-icon-light">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
							</svg>
						</span>
					</button>
				</div>
				@endif
				<!--end::Alert-->

				<a href="{{ url('/backup_database') }}" class="btn btn-primary btn-sm me-2 mb-2">Back Up Database</a>
				<a href="#" class="btn btn-info btn-sm me-2 mb-2"  data-bs-toggle="modal" data-bs-target="#modalDetail">Import Database</a>

				<form action="{{ url('/import_database') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal fade" tabindex="-1" id="modalDetail">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Import SQL</h5>

								<!--begin::Close-->
								<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
									<span class="svg-icon svg-icon-2x"></span>
								</div>
								<!--end::Close-->
							</div>

							<div class="modal-body">
								
								<div class="row g-5 g-xl-8">
									<div class="col-xl-12">
										<label>File SQL</label>
										<div class="form-group">
											<input type="file" name="file_sql" required="required">
										</div>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
								<a href="{{ url('/public/file_mission/import_mission.xlsx') }}" class="btn btn-warning">Download Format Import</a>
								<button type="submit" class="btn btn-primary">Import Data</button>
							</div>
						</div>
					</div>
				</div>

				</form>
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