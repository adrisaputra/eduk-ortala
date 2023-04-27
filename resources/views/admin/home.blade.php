@extends('admin/layout')
@section('konten')

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers " style="background: #445ede;">
				<div class="widget-heading">
					<h3 style="color: #ffffff;margin-top: 8px;">Selamat Datang "Administrator"</h3>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #2196f3;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h6 style="color: #ffffff;">Jumlah Pegawai</h6>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #8bc34a;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h6 style="color: #ffffff;">Jumlah Usul Naik Pangkat</h6>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #ffc107;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h6 style="color: #ffffff;">Jumlah Usul Pindah</h6>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #F44336;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h5 style="color: #ffffff;">Jumlah Usul KGB</h5>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #607d8b;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h6 style="color: #ffffff;">Cuti</h6>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
			<div class="widget widget-one_hybrid widget-followers" style="background: #00bcd4;">
				<div class="widget-heading">
					<div class="row" style="color: #ffffff;">
						<div class="col-md-8">
							<p class="w-value" style="color: #ffffff;font-size: 35px;">12</p>
							<h6 style="color: #ffffff;">Tugas Luar</h6>
						</div>
						<div class="col-md-4">
							<center>
								<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
							</center>
						</div>
					</div>
				</div>
				<div class="widget-content">    
					<div class="w-chart">
						<div id="hybrid_followers"></div>
					</div>
				</div>
			</div>
		</div>


		</div>

	</div>
	<div class="footer-wrapper">
		<div class="footer-section f-section-1">
		<p class="">Copyright © 2020 <a target="_blank" href="https://designreset.com">DesignReset</a>, All rights reserved.</p>
		</div>
		<div class="footer-section f-section-2">
		<p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
		</div>
	</div>
</div>
<!--  END CONTENT AREA  -->
@endsection