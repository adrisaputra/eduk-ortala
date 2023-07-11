@extends('admin/layout')
@section('konten')
<style>
    .selected-row td {
        background-color: #bbeaff;
    }
</style>
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
							 		<h4>Data {{ __($title) }} 
										@if(Request::segment(1)=="class_employee") 
											(Riwayat Golongan) 
										@elseif(Request::segment(1)=="education_employee") 
											(Riwayat Pendidikan) 
										@elseif(Request::segment(1)=="position_employee") 
											(Riwayat Jabatan) 
										@elseif(Request::segment(1)=="punishment_employee") 
											(Riwayat Hukuman) 
										@elseif(Request::segment(1)=="absence_employee") 
											(Riwayat Absensi) 
										@elseif(Request::segment(1)=="leave_employee") 
											(Riwayat Cuti) 
										@elseif(Request::segment(1)=="family_employee") 
											(Riwayat Keluarga) 
										@elseif(Request::segment(1)=="family_employee") 
											(Riwayat Diklat) 
										@endif</h4>
                                    </div>                 
                                </div>
                            </div>

					   	<form action="{{ url(Request::segment(1).'/search') }}" method="GET">		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="col-xl-8 col-md-12 col-sm-12 col-12">
										<!-- <a href="{{ url(Request::segment(1).'/create') }}" class="btn mb-2 mr-1 btn-success snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a> -->
										@if(Request::segment(1)=="employee")
											<a href="#" onclick="sync()" class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning snackbar-bg-warning" data-toggle="tooltip" data-placement="top" title="Refresh">Refresh</a>
											<a id="editButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Data" disabled>Edit</a>
										@elseif(Request::segment(1)=="class_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowClassButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Golongan" disabled>Lihat Riwayat Golongan</a>
										@elseif(Request::segment(1)=="education_employee")
											<a href="#" onclick="sync()" class="btn mb-2 mr-1 btn-info  warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowEducationButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Pendidikan" disabled>Lihat Riwayat Pendidikan</a>
										@elseif(Request::segment(1)=="position_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowPositionButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Jabatan" disabled>Lihat Riwayat Jabatan</a>
										@elseif(Request::segment(1)=="punishment_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowPunishmentButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Hukuman" disabled>Lihat Riwayat Hukuman</a>
										@elseif(Request::segment(1)=="absence_employee")
										<button type="button" class="btn mb-2 mr-1 btn-info snackbar-bg-info" data-toggle="modal" data-target="#exampleModal">Sinkronisasi</button>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowAbsenceButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Absensi" disabled>Lihat Riwayat Absensi</a>
										@elseif(Request::segment(1)=="leave_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowLeaveButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Cuti" disabled>Lihat Riwayat Cuti</a>
										@elseif(Request::segment(1)=="family_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowFamilyButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Keluarga" disabled>Lihat Riwayat Keluarga</a>
										@elseif(Request::segment(1)=="training_employee")
											<a href="#" onclick="sync()"class="btn mb-2 mr-1 btn-info warning confirm" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
											<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
											<a id="ShowTrainingButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Lihat Riwayat Keluarga" disabled>Lihat Riwayat Diklat</a>
										@endif
									</div>
									<div class="col-xl-4 col-md-12 col-sm-12 col-12">
										<div class="input-group" >
											<input type="text" name="search" style="height: calc(1.4em + 1.4rem + -4px);" class="form-control" placeholder="Masukkan Pencarian" aria-label="Masukkan Pencarian" id="search" onkeyup="tampil()" onkeypress="disableEnterKey(event)">
										</div>
									</div>
								</div>
							</div>
						</form>
						
						<!-- Modal -->
						<form action="{{ url('absence_history_sync_all') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
						{{ csrf_field() }}
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Sinkronisasi</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
											</button>
										</div>
										<div class="modal-body">
											<div class="row" style="margin-top:20px">
												<div class="col-xl-6 col-lg-6 col-sm-6" style="font-size:16px">
													<select name="month" class="form-control form-control-sm">
														<option value="">- Pilih Bulan-</option>
														<option value="01" @if(date('m')=="01") selected @endif>JANUARI</option>
														<option value="02" @if(date('m')=="02") selected @endif>FEBRUARI</option>
														<option value="03" @if(date('m')=="03") selected @endif>MARET</option>
														<option value="04" @if(date('m')=="04") selected @endif>APRIL</option>
														<option value="05" @if(date('m')=="05") selected @endif>MEI</option>
														<option value="06" @if(date('m')=="06") selected @endif>JUNI</option>
														<option value="07" @if(date('m')=="07") selected @endif>JULI</option>
														<option value="08" @if(date('m')=="08") selected @endif>AGUSTUS</option>
														<option value="09" @if(date('m')=="09") selected @endif>SEPTEMBER</option>
														<option value="10" @if(date('m')=="10") selected @endif>OKTOBER</option>
														<option value="11" @if(date('m')=="11") selected @endif>NOVEMBER</option>
														<option value="12" @if(date('m')=="12") selected @endif>DESEMBER</option>
													</select>
												</div>
												<div class="col-xl-6 col-lg-6 col-sm-6" style="font-size:16px">
													<select name="year" class="form-control form-control-sm">
														<option value="">- Pilih Tahun-</option>
														@for($i=2021;$i<=date('Y');$i++)
															<option value="{{ $i }}" @if(date('Y')==$i) selected @endif>{{ $i }}</option>
														@endfor
													</select>
												</div>
											</div>

										</div>
										<div class="modal-footer">
											<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
											<button type="submit" class="btn btn-success">Proses</button>
										</div>
									</div>
								</div>
							</div>
						</form>


                            <div class="widget-content widget-content-area" style="padding-top: 0px;">

								@if($synchronization->status == "Process")
									<div class="w-browser-details" id="synchronization">
										<div class="w-browser-info">
											<h6>Proses Sinkronisasi <b>(0%)</b></h6>
										</div>
										<div class="w-browser-stats">
											<div class="progress">
												<div class="progress-bar bg-gradient-success" role="progressbar" style="background-image: linear-gradient(to right, #8BC34A 0%, #4CAF50 100%);width: 0%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								@endif
                    
								@if ($message = Session::get('status'))
									<div class="alert alert-info mb-4" role="alert"> 
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
										</button> <h4 style="color: #ffffff;"><i class="image fa fa-check"></i> Berhasil !</h4>
										{{ $message }}
									</div>     
								@endif

								<div id="hasil">
									<div class="table-responsive">
									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%" rowspan=2>No</th>
												<th rowspan=2>NIP</th>
												<th rowspan=2>Nama</th>
												<th colspan=2>Pangkat</th>
												<!-- <th rowspan=2>Unor</th> -->
												<th rowspan=2>Unor Induk</th>
												<th rowspan=2>Status Pegawai</th>
											</tr>
											<tr>
												<th>Gol.</th>
												<th>TMT</th>
											</tr>
										</thead>
										<tbody>
										@foreach($employee as $v)
											<tr onclick="selectRow(this)">
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($employee ->currentpage()-1) * $employee ->perpage() + $loop->index + 1 }}</td>
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->front_title }} {{ $v->name }} {{ $v->back_title }}</td>
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->classes ? $v->classes->class : '' }}</td>
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->classes && $v->classes->class_history($v->nip)->first() ? date('d-m-Y', strtotime($v->classes->class_history($v->nip)->first()->tmt)) : '' }}</td>
												<!-- <td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->unit ? $v->unit->name : '' }}</td> -->
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->parent->name }}</td>
												<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->status }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
									<div class="paginating-container">{{ $employee->appends(Request::only('search'))->links() }}</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<script>
    function disableEnterKey(event) {
      if (event.key === "Enter") {
        event.preventDefault();
      }
    }
</script>
<script>
	// Fungsi untuk mendapatkan elemen dengan ID tertentu
	function getElementById(elementId) {
		return document.getElementById(elementId);
	}

	function getEmployee(id){
		// Mendapatkan nilai ID dengan menghapus "employee-" dari awal ID
		var employeeId = id.replace("employee-", "");
		console.log("ID pegawai yang diklik:", employeeId);

		@if(Request::segment(1)=="employee")

		// Mengaktifkan tombol edit
			var editButton = document.getElementById("editButton");
			editButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			editButton.classList.remove("btn-default");
			editButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/employee/edit') }}"
			editButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="class_employee")
		
			var ShowClassButton = document.getElementById("ShowClassButton");
			ShowClassButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowClassButton.classList.remove("btn-default");
			ShowClassButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/class_history/') }}"
			ShowClassButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="education_employee")
		
			var ShowEducationButton = document.getElementById("ShowEducationButton");
			ShowEducationButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowEducationButton.classList.remove("btn-default");
			ShowEducationButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/education_history/') }}"
			ShowEducationButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="position_employee")
		
			var ShowPositionButton = document.getElementById("ShowPositionButton");
			ShowPositionButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowPositionButton.classList.remove("btn-default");
			ShowPositionButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/position_history/') }}"
			ShowPositionButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="punishment_employee")
		
			var ShowPunishmentButton = document.getElementById("ShowPunishmentButton");
			ShowPunishmentButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowPunishmentButton.classList.remove("btn-default");
			ShowPunishmentButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/punishment_history/') }}"
			ShowPunishmentButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="absence_employee")
		
			var ShowAbsenceButton = document.getElementById("ShowAbsenceButton");
			ShowAbsenceButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowAbsenceButton.classList.remove("btn-default");
			ShowAbsenceButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/absence_history/') }}"
			ShowAbsenceButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="leave_employee")
		
			var ShowLeaveButton = document.getElementById("ShowLeaveButton");
			ShowLeaveButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowLeaveButton.classList.remove("btn-default");
			ShowLeaveButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/leave_history/') }}"
			ShowLeaveButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="family_employee")
		
			var ShowFamilyButton = document.getElementById("ShowFamilyButton");
			ShowFamilyButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowFamilyButton.classList.remove("btn-default");
			ShowFamilyButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/family_history/') }}"
			ShowFamilyButton.href = ""+url+"/"+employeeId;

		@elseif(Request::segment(1)=="training_employee")
		
			var ShowTrainingButton = document.getElementById("ShowTrainingButton");
			ShowTrainingButton.removeAttribute("disabled");
			// Mengubah kelas tombol edit
			ShowTrainingButton.classList.remove("btn-default");
			ShowTrainingButton.classList.add("btn-success");

			// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
			url = "{{ url('/training_history/') }}"
			ShowTrainingButton.href = ""+url+"/"+employeeId;

		@endif

	}

	// Menambahkan event listener untuk mendeteksi klik di luar elemen dengan ID pegawai
	document.addEventListener("click", function(event) {
		var clickedElement = event.target;
		var editButton = getElementById("editButton");
		// Memeriksa apakah elemen yang diklik bukanlah <td> dengan ID pegawai atau tombol edit itu sendiri
		if (!clickedElement.matches("td[id^='employee-']") && clickedElement !== editButton) {
			// Menonaktifkan tombol edit
			editButton.setAttribute("disabled", "disabled");
			// Mengubah kelas tombol edit
			editButton.classList.remove("btn-success");
			editButton.classList.add("btn-default");
			// Mengosongkan atribut href pada tombol edit
			editButton.removeAttribute("href");
		}
	});

    var selectedRow = null;

    function selectRow(row) {
        // Memeriksa apakah baris sudah dipilih sebelumnya
        if (selectedRow !== null) {
            // Menghapus class 'selected-row' dari baris sebelumnya
            selectedRow.classList.remove("selected-row");
        }

        // Menyimpan referensi ke baris yang baru dipilih
        selectedRow = row;

        // Menambahkan class 'selected-row' pada baris yang baru dipilih
        selectedRow.classList.add("selected-row");

    }
</script>
<script>
function tampil(){
    search = document.getElementById("search").value;
    url = "{{ url('/employee/search') }}"
    $.ajax({
        url:""+url+"?search="+search+"",
        success: function(response){
            $("#hasil").html(response);
        }
    });
    return false;
}
</script>
<script>
function sync(){

	$('.widget-content .warning.confirm').on('click', function () {
        swal({
            title: 'Apakah Anda Yakin Akan Melakukan Sinkronisasi Data ?',
            // text: "Anda tidak akan dapat mengembalikan ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sinkronisasi',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                    swal(
                    'Success!',
                    'Data Sedang Disinkronisasi.',
                    'success'
                    ).then(function() {
						@if(Request::segment(1)=="employee")
							var url = "{{ url(Request::segment(1).'/sync') }}";
						@elseif(Request::segment(1)=="class_employee")
							var url = "{{ url('class_history_sync_all') }}";
						@elseif(Request::segment(1)=="education_employee")
							var url = "{{ url('education_history_sync_all') }}";
						@elseif(Request::segment(1)=="position_employee")
							var url = "{{ url('position_history_sync_all') }}";
						@elseif(Request::segment(1)=="punishment_employee")
							var url = "{{ url('punishment_history_sync_all') }}";
						@elseif(Request::segment(1)=="absence_employee")
							var url = "{{ url('absence_history_sync_all') }}";
						@elseif(Request::segment(1)=="leave_employee")
							var url = "{{ url('leave_history_sync_all') }}";
						@elseif(Request::segment(1)=="family_employee")
							var url = "{{ url('family_history_sync_all') }}";
						@elseif(Request::segment(1)=="training_employee")
							var url = "{{ url('training_history_sync_all') }}";
						@endif
						$.ajax({
							url:url,
							success: function(response){
								// $("#hasil").html(response);
								console.log("berhasil");
							}
						});
						
						window.setTimeout(function() {
							window.location.href = "{{ url(Request::segment(1)) }}";
						}, 1000); // 10000 milidetik = 1 detik
					});
                }
            })
        })
}
</script>
<script> 
	$(document).ready(function(){
		setInterval(function(){
			$("#synchronization").load(window.location.href + "/refresh" );
		}, 1000);
	});
</script>
@endsection