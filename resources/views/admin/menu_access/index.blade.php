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
			<div class="card-header border-0 pt-6">
				<!--begin::Card title-->
				<div class="card-title">
					<!--begin::Search-->
					
					<form action="{{ url('/'.Request::segment(1).'/search/'.Crypt::encrypt($group->id)) }}" method="GET">
					<div class="d-flex align-items-center position-relative my-1">
						<span class="svg-icon svg-icon-1 position-absolute ms-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
								<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
							</svg>
						</span>
						<input type="text" data-kt-menu_access-table-filter="search" class="form-control form-control-solid w-300px ps-14 btn-sm " name="search" placeholder="Cari Akses Menu" />
					</div>
					</form>
					<!--end::Search-->
				</div>
				<!--begin::Card title-->
				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<!--begin::Toolbar-->
					<div class="d-flex justify-content-end" data-kt-menu_access-table-toolbar="base">
						<a href="{{ url('/group') }}" class="btn btn-danger btn-icon btn-sm me-2 mb-2" title="Kembali"><i class="fa fa-arrow-left"></i></a>
						<a href="{{ url('/'.Request::segment(1).'/'.Crypt::encrypt($group->id)) }}" class="btn btn-warning btn-icon btn-sm me-2 mb-2" title="Refresh Halaman"><i class="fa fa-undo"></i></a>
						<a href="{{ url('/'.Request::segment(1).'/create/'.Crypt::encrypt($group->id)) }}" class="btn btn-primary btn-sm me-2 mb-2"><i class="fa fa-plus"></i>Tambah Akses Menu</a>
					</div>
				</div>
				<!--end::Card toolbar-->
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

				<!--begin::Table-->
				<div class="table-responsive">
				<table class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-7 gs-7" id="kt_table_menu_access">
					<!--begin::Table head-->
					<thead>
						<!--begin::Table row-->
						<tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
							<th style="width: 2%">No</th>
							<th>Nama Menu</th>
							<th>Create</th>
							<th>Read</th>
							<th>Update</th>
							<th>Delete</th>
							<th>Print</th>
							<th style="width: 25%">#Aksi</th>
						</tr>
						<!--end::Table row-->
					</thead>
					<!--end::Table head-->
					<!--begin::Table body-->
					<tbody class="text-gray-600 fw-bold">
						@foreach($menu_access as $v)
						<tr>
							<td>{{ ($menu_access ->currentpage()-1) * $menu_access ->perpage() + $loop->index + 1 }}</td>
							<td>{{ $v->menu->menu_name }}</td>
							@if($v->menu->link=="#")
								<td colspan=5></td>
							@else
								<td>
									@if($v->create==1)
										<i class="fa fa-check text-green"></i>
									@endif
								</td>
								<td>
									@if($v->read==1)
										<i class="fa fa-check text-green"></i>
									@endif
								</td>
								<td>
									@if($v->update==1)
										<i class="fa fa-check text-green"></i>
									@endif
								</td>
								<td>
									@if($v->delete==1)
										<i class="fa fa-check text-green"></i>
									@endif
								</td>
								<td>
									@if($v->print==1)
										<i class="fa fa-check text-green"></i>
									@endif
								</td>
							@endif
							<td>
								@if($v->menu->link=="#")
									<a href="{{ url('/sub_menu_akses/'.Crypt::encrypt($group->id).'/'.Crypt::encrypt($v->menu_id) ) }}" class="btn btn-sm btn-info"><i class="fa fa-list"></i>Sub Menu Akses</a>
								@endif
								<a href="{{ url('/'.Request::segment(1).'/edit/'.Crypt::encrypt($group->id).'/'.Crypt::encrypt($v->id) ) }}" class="btn btn-icon btn-sm btn-warning"><i class="fa fa-edit"></i></a>
								<a href="{{ url('/'.Request::segment(1).'/hapus/'.Crypt::encrypt($group->id).'/'.Crypt::encrypt($v->id) ) }}" class="btn btn-icon btn-sm btn-danger"  onclick="return confirm('Anda Yakin ?');"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
					<!--end::Table body-->
				</table>
				<!-- PAGINATION -->
				<div style="div-align:right">{{ $menu_access->appends(Request::only('search'))->links() }}</div>
				</div>
				<!--end::Table-->
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