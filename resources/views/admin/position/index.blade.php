@extends('admin/layout')
@section('konten')
<style>
    .selected-row td {
        background-color: #bbeaff;
    }
    #loading-message {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      color: #fff;
      font-size: 24px;
      text-align: center;
      padding-top: 200px;
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
										<a href="{{ url(Request::segment(1).'/sync') }}" class="btn mb-2 mr-1 btn-info snackbar-bg-info" data-toggle="tooltip" data-placement="top" title="Sinkronisasi Data">Sinkronisasi</a>
										<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning snackbar-bg-warning" data-toggle="tooltip" data-placement="top" title="Refresh">Refresh</a>
										<!-- <a id="editButton" href="#" class="btn mb-2 mr-1 btn-default snackbar-bg-success" data-toggle="tooltip" data-placement="top" title="Edit Data" disabled>Edit</a> -->
									</div>
									<div class="col-xl-4 col-md-12 col-sm-12 col-12">
										<div class="input-group" >
											<input type="text" name="search" style="height: calc(1.4em + 1.4rem + -4px);" class="form-control" placeholder="Masukkan Pencarian" aria-label="Masukkan Pencarian" id="search" onkeyup="tampil()" onkeypress="disableEnterKey(event)">
										</div>
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
							<div id="loading-message">Loading data...</div>
								<div id="hasil">
									<div class="table-responsive">
									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%">No</th>
												<th>Nama Jabatan</th>
												<th>Jenis Jabatan</th>
											</tr>
										</thead>
										<tbody>
										@foreach($position as $v)
											<tr onclick="selectRow(this)">
												<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($position ->currentpage()-1) * $position ->perpage() + $loop->index + 1 }}</td>
												<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
												<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->type }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
									<div class="paginating-container">{{ $position->appends(Request::only('search'))->links() }}</div>
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
		// Mendapatkan nilai ID dengan menghapus "position-" dari awal ID
		var positionId = id.replace("position-", "");
		console.log("ID pegawai yang diklik:", positionId);

		// Mengaktifkan tombol edit
		var editButton = document.getElementById("editButton");
		editButton.removeAttribute("disabled");
		// Mengubah kelas tombol edit
		editButton.classList.remove("btn-default");
		editButton.classList.add("btn-success");

		// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
		url = "{{ url('/position/edit') }}"
		editButton.href = ""+url+"/"+positionId;
	}

	// Menambahkan event listener untuk mendeteksi klik di luar elemen dengan ID pegawai
	document.addEventListener("click", function(event) {
		var clickedElement = event.target;
		var editButton = getElementById("editButton");
		// Memeriksa apakah elemen yang diklik bukanlah <td> dengan ID pegawai atau tombol edit itu sendiri
		if (!clickedElement.matches("td[id^='position-']") && clickedElement !== editButton) {
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
    url = "{{ url('/position/search') }}"
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
						url = "{{ url('/position/delete') }}"
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
<script>
    document.onreadystatechange = function() {
      if (document.readyState === 'complete') {
        document.getElementById('loading-message').style.display = 'none';
      } else {
        document.getElementById('loading-message').style.display = 'block';
      }
    };
  </script>
@endsection