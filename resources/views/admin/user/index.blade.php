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
							 	<h4>Data User</h4>
                                    </div>                 
                                </div>
                            </div>

					   	<form action="{{ url('user/search') }}" method="GET">		
							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="col-xl-8 col-md-12 col-sm-12 col-12">
										<a href="{{ url(Request::segment(1).'/create') }}" class="btn mb-2 mr-1 btn-success">Tambah Data</a>	
										<a href="{{ url('user') }}" class="btn mb-2 mr-1 btn-warning ">Refresh</a>
									</div>
									<div class="col-xl-4 col-md-12 col-sm-12 col-12">
										<div class="input-group" >
											<input type="text" name="search" style="height: calc(1.4em + 1.4rem + -4px);" class="form-control" placeholder="Masukkan Pencarian" aria-label="Masukkan Pencarian" id="search" onkeyup="tampil()">
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
										<table class="table table-bordered table-hover mb-4">
											<thead>
												<tr>
													<th style="width: 2%">No</th>
													<th>Nama User</th>
													<th>Email</th>
													<th>Group</th>
													<th>Status</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
											@foreach($user as $v)
												<tr>
													<td class="text-center">{{ ($user ->currentpage()-1) * $user ->perpage() + $loop->index + 1 }}</td>
													<td style="width:40%">{{ $v->name }}</td>
													<td style="width:40%">{{ $v->email }}</td>
													<td>@if($v->group_id==1)
														<span class="badge badge-info">Administrator</span>
														@elseif($v->group_id==2)
															<span class="badge badge-primary">Admin Biro</span>
														@elseif($v->group_id==3)
															<span class="badge badge-warning">Tamu</span>
														@endif
													</td>
													<td>@if($v->status==0)
														<span class="badge badge-danger">Tidak Aktif</span>
														@elseif($v->status==1)
														<span class="badge badge-success">Aktif</span>
														@endif
													</td>
													<td class="col-md-3">
														<a href="{{ url('/user/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
														</a>
														@if($v->id !=1)
																<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></href>
														@endif
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
										<div class="paginating-container">{{ $user->appends(Request::only('search'))->links() }}</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<script>
function tampil(){
    search = document.getElementById("search").value;
    url = "{{ url('/user/search') }}"
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
                    'Data Barang Berhasil Dihapus.',
                    'success'
                    ).then(function() {
						url = "{{ url('/user/hapus') }}"
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