@extends('admin/layout')
@section('konten')

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

					   	<form action="{{ url(Request::segment(1).'/print') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
						   {{ csrf_field() }}		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="@if(Auth::user()->group_id==1) col-xl-4 @else col-xl-8 @endif col-md-12 col-sm-12 col-12">
										@if(Auth::user()->group_id!=1)
											<a href="{{ url(Request::segment(1).'/create') }}" class="btn mb-2 mr-1 btn-success">Tambah Data</a>	
										@endif
										<a href="{{ url('presence_recapitulation') }}" class="btn mb-2 mr-1 btn-warning ">Refresh</a>
										<button type="submit" class="btn mb-2 mr-1 btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></button>
									</div>
                                    
									<div class="col-xl-2 col-md-12 col-sm-12 col-12">
										<select id="year" name="year" onChange="tampil()" class="form-control control-sm" style="height: 38px;padding: 5px;">
											<option value="">Pilih Tahun</option>
											@for ($i = date('Y'); $i >= 2020; $i--)
												<option value="{{ $i }}" @if($i == date('Y')) selected @endif>Tahun {{ $i }}</option>
											@endfor
										</select>
									</div>

									<div class="col-xl-2 col-md-12 col-sm-12 col-12">
										<select class="form-control control-sm" name="month" id="month" onChange="tampil()" style="height: 38px;padding: 5px;">
											<option value="">- Pilih Periode -</option>
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
                                    
									@if(Auth::user()->group_id==1)
										<div class="col-xl-4 col-md-12 col-sm-12 col-12">
											<select name="parent_unit_id" class="form-control form-control-sm" id="parent_unit_id" onchange="tampil()" style="height: 38px;padding: 5px;">
												<option value="">- Pilih Unor Induk-</option>
												@foreach($parent_unit as $v)
													<option value="{{ $v->id }}" @if(request()->get('parent_unit_id')== $v->id) selected @endif>{{ $v->name }}</option>
												@endforeach
											</select>
										</div>
									@else
										<input type="hidden" name="parent_unit_id" id="parent_unit_id" value="{{ Auth::user()->parent_unit_id }}">
									@endif
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
										<table class="table table-bordered table-hover mb-4">
											<thead>
												<tr>
													<th rowspan=2>No</th>
													<th rowspan=2>Hari/Tanggal</th>
													<th rowspan=2>Jumlah ASN</th>
													<th colspan=6>Laporan</th>
													<th rowspan=2>Ket</th>
													@if(Auth::user()->group_id!=1)
														<th rowspan=2></th>
													@endif
												</tr>
												<tr>
													<th>TL</th>
													<th>Cuti</th>
													<th>Sakit</th>
													<th>Hadir</th>
													<th>Tanpa Keterangan (Tidak Hadir)</th>
													<th>Rata-rata Hadir (%)</th>
												</tr>
											</thead>
											<tbody>
											@if($presence_recapitulation)
											@foreach($presence_recapitulation as $v)
												<tr>
													<td class="text-center">{{ ($presence_recapitulation ->currentpage()-1) * $presence_recapitulation ->perpage() + $loop->index + 1 }}</td>
													<td style="width:20%">{{ $v->day }}, {{ date('d-m-Y', strtotime($v->date)) }}</td>
													<td style="width:20%">{{ $v->employee_amount }}</td>
													<td>{{ $v->tl }}</td>
													<td>{{ $v->ct }}</td>
													<td>{{ $v->s }}</td>
													<td>{{ $v->h }}</td>
													<td>{{ $v->th }}</td>
													<td>
                                                        @php
                                                            $x = $v->h; 
                                                            $persentase = ($x/$v->employee_amount)*100;
                                                        @endphp
                                                        {{ number_format($persentase, 2) }} %
                                                    </td>
													<td>{{ $v->desc }}</td>
													@if(Auth::user()->group_id!=1)
														<td>
															<a href="{{ url('/presence_recapitulation/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
															</a>
															<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
														</td>
													@endif
												</tr>
											@endforeach
											@endif
											</tbody>
										</table>
										
										@if($presence_recapitulation)
											<div class="paginating-container">{{ $presence_recapitulation->appends(Request::only('search'))->links() }}</div>
										@endif
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
    year = document.getElementById("year").value;
    month = document.getElementById("month").value;
    parent_unit_id = document.getElementById("parent_unit_id").value;
    url = "{{ url('/presence_recapitulation/search') }}"
    $.ajax({
        url:""+url+"?year="+year+"&&month="+month+"&&parent_unit_id="+parent_unit_id+"",
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
                    'Data Rekapitulasi Absensi Berhasil Dihapus.',
                    'success'
                    ).then(function() {
						url = "{{ url('/presence_recapitulation/delete') }}"
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