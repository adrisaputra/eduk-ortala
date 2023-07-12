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

					   	<form action="{{ url('promotion_file/search') }}" method="GET">		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="col-xl-8 col-md-12 col-sm-12 col-12">
										@if(Auth::user()->group_id=="2")
											<a href="{{ url(Request::segment(1).'/'.Request::segment(2).'/create') }}" class="btn mb-2 mr-1 btn-success">Tambah Data</a>	
										@endif
										<a href="{{ url(Request::segment(1).'/'.Request::segment(2)) }}" class="btn mb-2 mr-1 btn-warning ">Refresh</a>
										<a href="{{ url('promotion') }}" class="btn mb-2 mr-1 btn-danger ">Kembali</a>
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
					
                                <div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label required">{{ __('NIP') }}</label>
										<input type="text" class="form-control" value="{{ $promotion->nip }}" readonly/>
									</div>
									<div class="col-md-6 mb-3">
										<label class="form-label required">{{ __('Nama Pegawai') }}</label>
										<input type="text" class="form-control" value="{{ $promotion->employee->name }}" readonly/>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label required">{{ __('Pangkat Lama') }}</label>
										<input type="text" class="form-control" value="{{ $promotion->last_promotion }}" readonly/>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label required">{{ __('Pangkat Baru') }}</label>
										<input type="text" class="form-control" value="{{ $promotion->new_promotion }}" readonly/>
									</div>
									<div class="col-md-4 mb-3">
										<label class="form-label required">{{ __('Jenis Kenaikan') }}</label>
										<input type="text" class="form-control" value="{{ $promotion->promotion_type }}" readonly/>
									</div>
								</div>

								<div id="hasil">
									<div class="table-responsive">
										<table class="table table-bordered table-hover mb-4">
											<thead>
												<tr>
													<th style="width: 2%">No</th>
													<th>Nama</th>
													<th>File</th>
													@if(Auth::user()->group_id=="2")
														<th></th>
													@endif
												</tr>
											</thead>
											<tbody>
											@foreach($promotion_file as $v)
												<tr>
													<td class="text-center">{{ ($promotion_file ->currentpage()-1) * $promotion_file ->perpage() + $loop->index + 1 }}</td>
													<td style="width:70%">{{ $v->name }}</td>
													<td><a href="{{ asset('upload/promotion_file/'.$v->file) }}" target="_blank" class="btn mr-1 btn-sm btn-info">Download File</a></td>
													@if(Auth::user()->group_id=="2")
														<td>
															<a href="{{ url('/promotion_file/edit/'.Request::segment(2).'/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
															</a>
															<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
														</td>
													@endif
												</tr>
											@endforeach
												<tr>
													<td colspan=4>
														<center>
															@if(Auth::user()->group_id=="2")
																<a href="{{ url('promotion/send/'.Crypt::encrypt($promotion->id))}}" class="btn mr-1 btn-success" onclick="return confirm('Apakah Anda Yakin Akan Mengirim Pengajuan Ini ?');">Kirim Pengajuan</a>
															@elseif(Auth::user()->group_id=="1")
																<a href="{{ url('promotion/accept/'.Crypt::encrypt($promotion->id))}}" class="btn mr-1 btn-success" onclick="return confirm('Apakah Anda Yakin Akan Menerima Pengajuan Ini ?');">Terima</a>
																<a href="{{ url('promotion/send/'.Crypt::encrypt($promotion->id))}}" class="btn mr-1 btn-info" onclick="return confirm('Apakah Anda Yakin Akan Mengirim Pengajuan Ini ?');">Perbaiki</a>
																<a href="{{ url('promotion/reject/'.Crypt::encrypt($promotion->id))}}" class="btn mr-1 btn-danger" onclick="return confirm('Apakah Anda Yakin Akan Menolak Pengajuan Ini ?');">Tolak</a>
															@endif
														</center>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="paginating-container">{{ $promotion_file->appends(Request::only('search'))->links() }}</div>
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
    search = document.getElementById("search").value;
    url = "{{ url('/promotion_file/search') }}"
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
                    'Data Undang-undang Berhasil Dihapus.',
                    'success'
                    ).then(function() {
						url = "{{ url('/promotion_file/delete') }}"
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