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
										<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning snackbar-bg-warning" data-toggle="tooltip" data-placement="top" title="Refresh">Refresh</a>
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
								<div id="hasil">
									<div class="table-responsive">
									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%">No</th>
												<th>Nama Unor Induk</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										@foreach($parent_unit as $i => $v)
											<tr onclick="selectRow(this)">
												<td id="parent_unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($parent_unit ->currentpage()-1) * $parent_unit ->perpage() + $loop->index + 1 }}</td>
												<td id="parent_unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
												<td class="col-md-3">
													@if(request()->segment(1)=="parent_unit_promotion")
														<a href="{{ url('/promotion/'.Crypt::encrypt($v->id)) }}" class="btn btn-info position-relative btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Pengajuan">Lihat Pengajuan
														@if($promotion[$i]>0)<span class="badge badge-danger counter">{{ $promotion[$i] }}</span></a>@endif
													@elseif(request()->segment(1)=="parent_unit_salary_increase")
														<a href="{{ url('/salary_increase/'.Crypt::encrypt($v->id)) }}" class="btn btn-info position-relative btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Pengajuan">Lihat Pengajuan
														@if($salary_increase[$i]>0)<span class="badge badge-danger counter">{{ $salary_increase[$i] }}</span></a>@endif
													@endif
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
									<div class="paginating-container">{{ $parent_unit->appends(Request::only('search'))->links() }}</div>
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
		// Mendapatkan nilai ID dengan menghapus "parent_unit-" dari awal ID
		var parent_unitId = id.replace("parent_unit-", "");
		console.log("ID pegawai yang diklik:", parent_unitId);

		// Mengaktifkan tombol edit
		var editButton = document.getElementById("editButton");
		editButton.removeAttribute("disabled");
		// Mengubah kelas tombol edit
		editButton.classList.remove("btn-default");
		editButton.classList.add("btn-success");

		// Mengubah atribut href pada tombol edit dengan menggunakan ID pegawai
		url = "{{ url('/parent_unit/edit') }}"
		editButton.href = ""+url+"/"+parent_unitId;
	}

	// Menambahkan event listener untuk mendeteksi klik di luar elemen dengan ID pegawai
	document.addEventListener("click", function(event) {
		var clickedElement = event.target;
		var editButton = getElementById("editButton");
		// Memeriksa apakah elemen yang diklik bukanlah <td> dengan ID pegawai atau tombol edit itu sendiri
		if (!clickedElement.matches("td[id^='parent_unit-']") && clickedElement !== editButton) {
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
    url = "{{ url('/parent_unit_promotion/search') }}"
    $.ajax({
        url:""+url+"?search="+search+"",
        success: function(response){
            $("#hasil").html(response);
        }
    });
    return false;
}
</script>
@endsection