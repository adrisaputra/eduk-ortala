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
							 		<h4>Data {{ __($title) }}</h4>
                                    </div>                 
                                </div>
                            </div>

					   	<form action="{{ url(Request::segment(1).'/search') }}" method="GET">		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="col-xl-8 col-md-12 col-sm-12 col-12">
										<a href="{{ url(Request::segment(1).'/sync/'.Request::segment(2)) }}" class="btn mb-2 mr-1 btn-info snackbar-bg-info" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
										<a href="{{ url(Request::segment(1).'/'.Request::segment(2)) }}" class="btn mb-2 mr-1 btn-warning" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></a>
										<a href="{{ url('family_employee') }}" class="btn mb-2 mr-1 btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a>
									</div>
								</div>
							</div>
						</form>
						
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
							@if ($message = Session::get('status'))
								<div class="alert alert-info mb-4" role="alert"> 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</button> <h4 style="color: #ffffff;"><i class="image fa fa-check"></i> Berhasil !</h4>
									{{ $message }}
								</div>     
							@endif
							@if ($message = Session::get('status2'))
								<div class="alert alert-danger mb-4" role="alert"> 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</button> <h4 style="color: #ffffff;"><i class="image fa fa-check"></i> Gagal !</h4>
									{{ $message }}
								</div>     
							@endif

								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label required">{{ __('NIP') }}</label>
										<input type="text" class="form-control" value="{{ $employee->nip }}" readonly/>
									</div>
									<div class="col-md-6 mb-3">
										<label class="form-label required">{{ __('Nama Pegawai') }}</label>
										<input type="text" class="form-control" value="{{ $employee->name }}" readonly/>
									</div>
								</div>

								<div id="hasil">
									<div class="table-responsive">
									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%">No</th>
												<th>Nama Orang Tua</th>
												<th>Tempat Lahir</th>
												<th>Tanggal Lahir</th>
												<th>Pekerjaan</th>
												<th>Alamat</th>
											</tr>
										</thead>
										<tbody>
											@if($parent_history)
											<tr onclick="selectRow(this)">
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">1</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->father_name }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->father_birthplace }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->father_birthdate }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->father_work }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->father_address }}</td>
											</tr>
											<tr onclick="selectRow(this)">
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">2</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->mother_name }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->mother_birthplace }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->mother_birthdate }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->mother_work }}</td>
												<td id="parent_history-{{ $parent_history->id }}" onClick="getEmployee(this.id)">{{ $parent_history->mother_address }}</td>
											</tr>
											@endif
										</tbody>
									</table>

									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%">No</th>
												<th>Nama Anak</th>
												<th>Tempat Lahir</th>
												<th>Tanggal Lahir</th>
												<th>Jenis Kelamin</th>
												<th>Pendidikan</th>
												<th>Pekerjaan</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										@foreach($child_history as $i => $v)
											<tr onclick="selectRow(this)">
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $i+1 }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_name }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_birthplace }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_birthdate }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_gender }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_education }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_work }}</td>
												<td id="child_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->child_status }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
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
		// Mendapatkan nilai ID dengan menghapus "parent_history-" dari awal ID
		var parent_historyId = id.replace("parent_history-", "");
		console.log("ID pegawai yang diklik:", parent_historyId);

		// Mengaktifkan tombol edit
		var editButton = document.getElementById("editButton");
		editButton.removeAttribute("disabled");
		// Mengubah kelas tombol edit
		editButton.classList.remove("btn-default");
		editButton.classList.add("btn-success");

		// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
		url = "{{ url('/parent_history/edit') }}"
		editButton.href = ""+url+"/"+parent_historyId;
	}

	// Menambahkan event listener untuk mendeteksi klik di luar elemen dengan ID pegawai
	document.addEventListener("click", function(event) {
		var clickedElement = event.target;
		var editButton = getElementById("editButton");
		// Memeriksa apakah elemen yang diklik bukanlah <td> dengan ID pegawai atau tombol edit itu sendiri
		if (!clickedElement.matches("td[id^='parent_history-']") && clickedElement !== editButton) {
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
    function DeleteData(id) {

        $('.widget-content .warning.confirm').on('click', function () {
        swal({
            title: 'Apakah Kamu Yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                    swal(
                    'Deleted!',
                    'Data Berita Berhasil Dihapus.',
                    'success'
                    ).then(function() {
						url = "{{ url('/parent_history/delete') }}"
                        $.ajax({
                            url:""+url+"/"+id+"",
                            success: function(response){
                                location.reload();
                            }
                        });
					});
                }
            })
        })
    }
</script>
@endsection