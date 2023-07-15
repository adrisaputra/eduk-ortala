@extends('admin/layout')
@section('konten')
<style>
.table-container {
  position: relative;
  max-height: 100%; /* Atur tinggi maksimal sesuai kebutuhan */
  /* overflow: hidden; */
}

.table-scroll {
  overflow-x: auto;
  /* max-height: inherit; */
  padding-bottom: 17px; /* Atur nilai sesuai lebar scrollbar */
}

table {
  /* width: 100%; */
  /* table-layout: fixed; */
}

.table-scroll::-webkit-scrollbar {
  height: 17px; /* Atur tinggi scrollbar */
}

.table-scroll::-webkit-scrollbar-track {
  background-color: #f1f1f1; /* Warna latar belakang track scrollbar */
}

.table-scroll::-webkit-scrollbar-thumb {
  background-color: #888; /* Warna scrollbar */
  border-radius: 10px; /* Atur border radius scrollbar */
}

.table-scroll::-webkit-scrollbar-thumb:hover {
  background-color: #555; /* Warna scrollbar saat dihover */
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
							 	<h4>Data {{ __($title) }} </h4>
                                    </div>                 
                                </div>
                            </div>

					   	<form action="{{ url(Request::segment(1).'/print') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
						   {{ csrf_field() }}		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="@if(Auth::user()->group_id==1) col-xl-6 @else col-xl-9 @endif  col-md-12 col-sm-12 col-12">
										<a href="{{ url(Request::segment(1)) }}" class="btn mb-2 mr-1 btn-warning ">Refresh</a>
										<button type="submit" class="btn mb-2 mr-1 btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></button>
									</div>
									@if(Auth::user()->group_id==1)
										<div class="col-xl-3 col-md-12 col-sm-12 col-12">
											<select name="parent_unit_id" class="form-control form-control-sm" id="parent_unit_id" onchange="tampil()">
												<option value="">- Pilih Unor Induk-</option>
												@foreach($parent_unit as $v)
													<option value="{{ $v->id }}" @if(request()->get('parent_unit_id')== $v->id) selected @endif>{{ $v->name }}</option>
												@endforeach
											</select>
										</div>
									@else
										<input type="hidden" id="parent_unit_id" value="{{ Auth::user()->parent_unit_id }}">
									@endif
									<div class="col-xl-3 col-md-12 col-sm-12 col-12">
										<div class="input-group" >
											<input type="text" name="search" value="{{ request()->get('search') }}" style="height: calc(1.4em + 1.4rem + -4px);" class="form-control" placeholder="Masukkan Pencarian" aria-label="Masukkan Pencarian" id="search" onkeyup="tampil()" onkeypress="disableEnterKey(event)">
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
								</button> <h4 style="color: #ffffff;"><i class="icon fa fa-check"></i> Berhasil !</h4>
								{{ $message }}
							</div>     
						@endif
					
								<div id="hasil">
									<div class="table-responsive"> 
										<div class="table-scroll">
										<table class="table table-bordered table-hover mb-4">
											<thead>
												<tr>
													<th style="width: 2%" rowspan=2>No</th>
													<th rowspan=2>NIP</th>
													<th rowspan=2>Nama</th>
													<th colspan=2>Pangkat</th>
													<th colspan=2>Jabatan</th>
													<th colspan=2>Masa Kerja</th>
													<th colspan=3>LPJ</th>
													<th colspan=3>Pendidikan</th>
													<th colspan=3>Lahir</th>
													<th rowspan=2>Ket.</th>
												</tr>
												<tr>
													<th>Gol.</th>
													<th>TMT</th>
													<th>Nama(Eselon)</th>
													<th>TMT</th>
													<th>Tahun</th>
													<th>Bulan</th>
													<th>Nama</th>
													<th>Tahun</th>
													<th>Jumlah</th>
													<th>Nama</th>
													<th>Lulus</th>
													<th>Tingkat</th>
													<th>Tempat</th>
													<th>Tanggal</th>
													<th>Usia</th>
												</tr>
											</thead>
											<tbody>
											@foreach($employee as $i => $v)
												<tr>
													<td class="text-center">{{ ($employee ->currentpage()-1) * $employee ->perpage() + $loop->index + 1 }}</td>
													<td>{{ $v->nip }}</td>
													<td>{{ $v->front_title }} {{ $v->name }} {{ $v->back_title }}</td>
													<td>{{ $v->classes ? $v->classes->class : '' }}</td>
													<td>{{ $v->classes && $v->classes->class_history($v->nip)->first() ? date('d-m-Y', strtotime($v->classes->class_history($v->nip)->first()->tmt)) : '' }}</td>
													<td>{{ $v->position_history($v->nip)->first() ? $v->position_history($v->nip)->first()->position : '' }} </td>
													<td>{{ $v->position_history($v->nip)->first() ? date('d-m-Y', strtotime($v->position_history($v->nip)->first()->tmt)) : '' }} </td>
													<td>{{ $masa_kerja[$i]['tahun'] }}</td>
													<td>{{ $masa_kerja[$i]['bulan'] }}</td>
													<td>{{ $v->training_history_first($v->nip)->first() ? $v->training_history_first($v->nip)->first()->name : '' }} </td>
													<td>{{ $v->training_history_first($v->nip)->first() ? date('d-m-Y', strtotime($v->training_history_first($v->nip)->first()->start)) : '' }} </td>
													<td>{{ $v->training_history_first($v->nip)->first() ? $v->training_history_first($v->nip)->first()->hours : '' }} </td>
													<td>{{ $v->education_history_last($v->nip)->first() ? $v->education_history_last($v->nip)->first()->education->name : '' }} </td>
													<td>{{ $v->education_history_last($v->nip)->first() ? date('d-m-Y', strtotime($v->education_history_last($v->nip)->first()->diploma_date)) : '' }}</td>
													<td>{{ $v->education_history_last($v->nip)->first() ? $v->education_history_last($v->nip)->first()->level : '' }}</td>
													
													<td>{{ $v->birthplace }}</td>
													<td>{{ date('d-m-Y', strtotime($v->date_of_birth )) }}</td>
													<td>{{ $usia[$i] }}</td>
													<td>{{ $v->status }}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
											<div class="paginating-container">{{ $employee->appends(Request::only('search','parent_unit_id'))->links() }}</div>
										</div>
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
function tampil(){
    parent_unit_id = document.getElementById("parent_unit_id").value;
    search = document.getElementById("search").value;
    url = "{{ url('/duk/search') }}"
    $.ajax({
        url:""+url+"?search="+search+"&&parent_unit_id="+parent_unit_id+"",
        success: function(response){
            $("#hasil").html(response);
        }
    });
    return false;
}
</script>
@endsection