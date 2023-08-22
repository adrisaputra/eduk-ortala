@extends('admin/layout')
@section('konten')
<style>
	
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

							<div class="widget-content widget-content-area">
								<div class="row">
									<div class="col-xl-8 col-md-12 col-sm-12 col-12">
										@if(Auth::user()->group_id=="2")
											@if($salary_increase->status=="Hold" || $salary_increase->status=="Diperbaiki" )
												<a href="{{ url(Request::segment(1).'/'.Request::segment(2).'/create') }}" class="btn mb-2 mr-1 btn-success">Tambah Data</a>	
												<a href="{{ url('salary_increase/send/'.Crypt::encrypt($salary_increase->id))}}" class="btn mb-2 mr-1 btn-info" onclick="return confirm('Apakah Anda Yakin Akan Mengirim Pengajuan Ini ?');notification2();">Kirim Pengajuan</a>            
												<!-- <a href="#" class="btn mb-2 mr-1 btn-info" onclick="notification2();">Kirim Pengajuans</a>             -->
											@endif
										@endif
										<a href="{{ url(Request::segment(1).'/'.Request::segment(2)) }}" class="btn mb-2 mr-1 btn-warning ">Refresh</a>
										<a href="{{ url('salary_increase') }}" class="btn mb-2 mr-1 btn-danger ">Kembali</a>
									</div>
								</div>
							</div>

                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
							@if ($message = Session::get('status'))
								<div class="alert alert-info mb-4" role="alert"> 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</button> <h4 style="color: #ffffff;"><i class="icon fa fa-check"></i> Berhasil !</h4>
									{{ $message }}
								</div>     
							@endif
					
                                <div class="row" style="margin-bottom:20px">

									@if($salary_increase->status=="Diperbaiki" || $salary_increase->note==TRUE && $salary_increase->status=="Dikirim")
										<div class="col-md-12 mb-3">
											<label class="form-label required" style="font-size:20px;color:black;font-weight:bold;">{{ __('Catatan Perbaikan') }} :</label>
											<p style="font-size:20px;color:red;font-weight:bold;margin-top:-10px;">{{ $salary_increase->note }}</p>
										</div>
									@endif

									<div class="col-md-3">
										{{ __('NIP') }}
									</div>
									<div class="col-md-9">
										<b>: {{ $salary_increase->nip }}</b>
									</div>

									<div class="col-md-3">
										{{ __('Nama Pegawai') }}
									</div>
									<div class="col-md-9">
										<b>: {{ $salary_increase->employee->name }}</b>
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Gaji Lama') }}
									</div>
									<div class="col-md-3">
										: Rp. {{ number_format($salary_increase->old_salary, 0, ',', '.') }}
									</div>

									<div class="col-md-3">
										{{ __('Gaji Pokok Baru') }}
									</div>
									<div class="col-md-3">
										: Rp. {{ number_format($salary_increase->new_salary, 0, ',', '.') }}
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Pejabat Yang Menetapkan') }}
									</div>
									<div class="col-md-3">
										: {{ $salary_increase->placeman }}
									</div>

									<div class="col-md-3">
										{{ __('Berdasarkan Masa Kerja') }}
									</div>
									<div class="col-md-3">
										: {{ $salary_increase->year_new_salary }} Tahun {{ $salary_increase->month_new_salary }} Bulan
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Tanggal SK') }}
									</div>
									<div class="col-md-3">
										: {{ date('d-m-Y', strtotime($salary_increase->sk_date)) }}
									</div>

									<div class="col-md-3">
										{{ __('Dalam Golongan') }}
									</div>
									<div class="col-md-3">
										: {{ $salary_increase->class }}
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Nomor SK') }}
									</div>
									<div class="col-md-3">
										: {{ $salary_increase->sk_number }}
									</div>

									<div class="col-md-3">
										{{ __('Tanggal Mulai') }}
									</div>
									<div class="col-md-3">
										: {{ date('d-m-Y', strtotime($salary_increase->start_new_date)) }}
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Tgl Mulai Berlaku Gaji Tersebut') }}
									</div>
									<div class="col-md-3">
										: {{ date('d-m-Y', strtotime($salary_increase->start_old_date)) }}
									</div>

									<div class="col-md-3">
										{{ __('Status Pegawai') }}
									</div>
									<div class="col-md-3">
										: Pegawai Negeri Sipil Daerah
									</div>

									<!-- ## -->
									<div class="col-md-3">
										{{ __('Masa Kerja Golongan Tgl tersebut') }}
									</div>
									<div class="col-md-3">
										: {{ $salary_increase->year_old_salary }} Tahun {{ $salary_increase->month_old_salary }} Bulan
									</div>

									<div class="col-md-3">
										{{ __('KGB Berikutnya') }}
									</div>
									<div class="col-md-3">
										: {{ date('d-m-Y', strtotime($salary_increase->next_kgb)) }}
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
											@foreach($salary_increase_file as $v)
												<tr>
													<td class="text-center">{{ ($salary_increase_file ->currentpage()-1) * $salary_increase_file ->perpage() + $loop->index + 1 }}</td>
													<td style="width:70%">{{ $v->name }}</td>
													<td><a href="{{ asset('upload/salary_increase_file/'.$v->file) }}" target="_blank" class="btn mr-1 btn-sm btn-info">Download File</a></td>
													@if(Auth::user()->group_id=="2")
														<td>
															@if($salary_increase->status=="Hold" || $salary_increase->status=="Diperbaiki" )
																<a href="{{ url('/salary_increase_file/edit/'.Request::segment(2).'/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
																</a>
																<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
															@endif
														</td>
													@endif
												</tr>
											@endforeach
												<tr>
													<td colspan=4>
														<center>
															
															@if(Auth::user()->group_id=="2")
																<!-- <a href="#" class="btn mr-1 btn-success" onclick="confirm('Apakah Anda Yakin Akan Mengirim Pengajuan Ini ?');add_to_cart({{ $salary_increase->id }})">Kirim Pengajuan</a> -->
															@elseif(Auth::user()->group_id=="1")
																<!-- <a href="{{ url('salary_increase/accept/'.Crypt::encrypt($salary_increase->id))}}" class="btn mr-1 btn-success" onclick="return confirm('Apakah Anda Yakin Akan Menerima Pengajuan Ini ?');">Terima</a> -->
																<button type="button" class="btn mr-1 btn-success" data-toggle="modal" data-target="#exampleModalAccept">Terima</button>
																<button type="button" class="btn mr-1 btn-info" data-toggle="modal" data-target="#exampleModal">Perbaiki</button>
																<!-- <a href="{{ url('salary_increase/reject/'.Crypt::encrypt($salary_increase->id))}}" class="btn mr-1 btn-danger" onclick="return confirm('Apakah Anda Yakin Akan Menolak Pengajuan Ini ?');">Tolak</a> -->
															@endif

															<!-- Modal -->
															<form action="{{ url('salary_increase/accept/'.Crypt::encrypt($salary_increase->id))}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
															{{ csrf_field() }}
																<div class="modal fade" id="exampleModalAccept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title" id="exampleModalLabel">Terima Dokumen</h5>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
																				</button>
																			</div>
																			<div class="modal-body">
																				<div class="form-group row mb-4">
																					<label class="col-xl-5 col-sm-3 col-sm-2 col-form-label">{{ __('Nomor Surat') }}  <span class="required" style="color: #dd4b39;">*</span></label>
																					<div class="col-xl-7 col-lg-9 col-sm-10">
																						<input type="text" class="form-control" placeholder="Nomor Surat" name="letter_number" required >
																					</div>
																				</div>
																				<div class="form-group row mb-4">
																					<label class="col-xl-5 col-sm-3 col-sm-2 col-form-label">{{ __('Tanggal Surat') }}  <span class="required" style="color: #dd4b39;">*</span></label>
																					<div class="col-xl-7 col-lg-9 col-sm-10">
																						<input name="letter_date" id="basicFlatpickr" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal" style="z-index: 1060;" required>
																					</div>
																				</div>
																				<div class="form-group row mb-4">
																					<label class="col-xl-5 col-sm-3 col-sm-2 col-form-label">{{ __('Jumlah Lampiran') }}  <span class="required" style="color: #dd4b39;">*</span></label>
																					<div class="col-xl-7 col-lg-9 col-sm-10">
																						<input type="text" class="form-control" placeholder="Jumlah Lampiran" name="attachment" required >
																					</div>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
																				<button type="submit" class="btn btn-success">Terima</button>
																			</div>
																		</div>
																	</div>
																</div>
															</form>

															<!-- Modal -->
															<form action="{{ url('salary_increase/fix_document/'.Crypt::encrypt($salary_increase->id))}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
															{{ csrf_field() }}
																<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title" id="exampleModalLabel">Perbaiki Dokumen</h5>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
																				</button>
																			</div>
																			<div class="modal-body">
																				<div class="row">
																					<div class="col-xl-12 col-lg-12 col-sm-12" style="font-size:16px">
																						<textarea class="form-control" name="note" required></textarea>
																					</div>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
																				<button type="submit" class="btn btn-info">Perbaiki</button>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
														</center>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="paginating-container">{{ $salary_increase_file->appends(Request::only('search'))->links() }}</div>
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
    url = "{{ url('/salary_increase_file/search') }}"
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
                    'Data File Pendukung Berhasil Dihapus.',
                    'success'
                    ).then(function() {
						url = "{{ url('/salary_increase_file/delete') }}"
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
<!-- <script>
	function notification2(){
		$("#salary_increase").load("{{ url('salary_increase/reload')}}" );
		console.log(1);
	}
</script> -->
@endsection