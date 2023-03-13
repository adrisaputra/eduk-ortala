@extends('admin/layout')
@section('konten')

<div class="toolbar">
	<!--begin::Toolbar-->
	<div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
		<div class="page-title d-flex flex-column me-5">
		</div>
		<div class="overflow-auto pt-3 pt-lg-0">
			<!--begin::Action wrapper-->
			<div class="">
				<div class="ms-lg-12" id="kt_header_user_menu_toggle" style="text-align: right;">
					<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
					@if (Auth::user()->foto)
						<img src="{{ asset('upload/foto/' . Auth::user()->foto) }}" alt="user">
					@else
						<img src="{{ asset('assets/profile-1-20210205190338.png') }}" alt="user">
					@endif
					</div>
					<!--begin::Menu-->
					<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
						<div class="menu-item px-3">
							<div class="menu-content d-flex align-items-center px-3">
								<div class="symbol symbol-50px me-5">
									@if (Auth::user()->foto)
										<img src="{{ asset('upload/foto/' . Auth::user()->foto) }}" alt="logo">
									@else
										<img src="{{ asset('assets/profile-1-20210205190338.png') }}" alt="logo">
									@endif
								</div>
								<div class="d-flex flex-column">
									<div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
								</div>
							</div>
						</div>
						<div class="separator my-2"></div>
						<div class="menu-item px-5">
							<a href="{{ url('/user/edit_profil/' . Crypt::encrypt(Auth::user()->id)) }}" class="menu-link px-5">Profil</a>
						</div>
						{{--<div class="menu-item px-5">
							<a href="../../demo1/dist/pages/projects/list.html" class="menu-link px-5">
								<span class="menu-text">My Projects</span>
								<span class="menu-badge">
									<span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
								</span>
							</a>
						</div>--}}
						<div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
							<a href="#" class="menu-link px-5">
								<span class="menu-title position-relative">Bahasa
								<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ strtoupper(Lang::locale()) }}
								@if(strtoupper(Lang::locale())=="ID")
									<img class="w-15px h-15px rounded-1 ms-2" src="{{ asset('assets/media/flags/indonesia.svg') }}" alt="" /></span></span>
								@else
									<img class="w-15px h-15px rounded-1 ms-2" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" /></span></span>
								@endif
							</a>
							<div class="menu-sub menu-sub-dropdown w-175px py-4">
								<div class="menu-item px-3">
									<a href="{{ url('lang/id') }}" class="menu-link d-flex px-5 active">
									<span class="symbol symbol-20px me-4">
										<img class="rounded-1" src="{{ asset('assets/media/flags/indonesia.svg') }}" alt="" />
									</span>Indonesia</a>
								</div>
								<div class="menu-item px-3">
									<a href="{{ url('lang/en') }}" class="menu-link d-flex px-5">
									<span class="symbol symbol-20px me-4">
										<img class="rounded-1" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
									</span>English</a>
								</div>
							</div>
						</div>
						@if(Auth::user()->group_id == 1)
						<div class="menu-item px-5">
							<a href="{{ url('/setting') }}" class="menu-link px-5">Pengaturan</a>
						</div>
						@endif
						<div class="menu-item px-5">
							<a href="{{ url('logout-sistem') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();" class="menu-link px-5">Keluar</a>
							<form id="logout-form" action="{{ url('logout-sistem') }}" method="POST" style="display: none;">
							@csrf
							</form>
						</div>
						<div class="separator my-2"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Toolbar-->
</div>
</div>
<!--end::Header-->
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Post-->
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<!--begin::Container-->
		<div id="kt_content_container" class="container-xxl">
			<!--begin::Row-->
			<div class="row g-5 g-xl-8">
				<div class="col-xl-4">
					<a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6" >
									<div class="text-white fw-bolder fs-2" style="font-size: 30px !important;">1</div>
									<div class="fw-bold text-white" >Jumlah Pegawai Sekretariat Daerah</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-list" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6">
									<div class="text-white fw-bolder fs-2" style="font-size: 30px !important;">2</div>
									<div class="fw-bold text-white">Jumlah Usul Naik Pangkat</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-list" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6">
									<div class="text-white fw-bolder fs-2" style="font-size: 30px !important;">2</div>
									<div class="fw-bold text-white">Jumlah Usul Pindah</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-list" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="#" class="card bg-danger hoverable card-xl-stretch mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6">
									<div class="text-white fw-bolder fs-2" style="font-size: 30px !important;">1</div>
									<div class="fw-bold text-white">Jumlah Usul Kenaikan Gaji Berkala</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-list" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6">
									<div class="text-white fw-bolder fs-2" style="font-size: 30px !important;">1</div>
									<div class="fw-bold text-white">Cuti</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-building" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="#" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-6">
									<div class="text-white fw-bolder fs-2">2</div>
									<div class="fw-bold text-white">Tugas Luar</div>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-6">
									<i class="fa fa-users" style="float: right;color:white;font-size:50px"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>	<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->
@endsection