<div id="hasil">
                                @if(request()->get('year'))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-4">
                                        <thead>
                                            <tr>
                                                <th style="width: 2%">No</th>
                                                <th>NIP/Nama</th>
                                                <th>Pangkat Lama</th>
                                                <th>Pangkat Baru</th>
                                                <th>Jenis Kenaikan</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $total = 0; $i = 0;@endphp
                                        @foreach($promotion as $v)
                                        @php $i = $i+1; @endphp
                                            <tr>
                                                <td class="text-center">{{ ($promotion ->currentpage()-1) * $promotion ->perpage() + $loop->index + 1 }}</td>
                                                <td style="width:30%">NIP : {{ $v->employee->nip }}<br>{{ $v->employee->front_title }} {{ $v->employee->name }} {{ $v->employee->back_title }}</td>
                                                <td style="width:14%">{{ $v->last_promotion }}</td>
                                                <td style="width:14%">{{ $v->new_promotion }}</td>
                                                <td style="width:14%">{{ $v->promotion_type }}</td>
                                                <td style="width:14%">
                                                    @if($v->status=="Hold")
                                                        <span class="badge badge-warning">Belum Dikirim</span>
                                                    @elseif($v->status=="Dikirim")
                                                        @if($v->note)
                                                            <span class="badge badge-primary">Sudah Diperbaiki</span><br><br>
                                                            Note :<br> {{ $v->note }}
                                                        @else
                                                            <span class="badge badge-primary">Sudah Dikirim</span>
                                                        @endif
                                                    @elseif($v->status=="Diperbaiki")
                                                        <span class="badge badge-info">Dokumen Salah</span><br><br>
                                                        Note :<br> {{ $v->note }}
                                                    @elseif($v->status=="Diterima")
                                                        <span class="badge badge-success">Terverifikasi</span>
                                                    @elseif($v->status=="Ditolak")
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="col-md-3">
                                                    @if(Auth::user()->group_id=="2")
                                                        @if($v->status=="Hold")
                                                            <a href="{{ url('/promotion_file/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="File Pendukung">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file text-info"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                                            </a>
                                                            <a href="{{ url('/promotion/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                            </a>
                                                            <a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                                        @elseif($v->status=="Diperbaiki")
                                                            <a href="{{ url('/promotion_file/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="File Pendukung">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file text-info"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                                            </a>
                                                            <a href="{{ url('/promotion/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                            </a>
                                                            <a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                                        @endif
                                                    @elseif(Auth::user()->group_id=="1")
                                                        @if($v->status=="Dikirim")
                                                        <a href="{{ url('/promotion_file/'.Crypt::encrypt($v->id)) }}" class="btn mb-2 mr-1 btn-success ">Verifikasi</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan=7>
                                                <center>
                                                    @if($count_promotion_hold)
                                                        <a href="{{ url('promotion/send/'.request()->get('year').'/'.request()->get('period'))}}" class="btn mr-1 btn-success" onclick="confirm('Apakah Anda Yakin Akan Mengirim Pengajuan Ini ?');">Kirim Pengajuan</a>
                                                    @endif	

                                                    <!-- Modal -->
                                                    <form action="{{ url('promotion/fix_document/')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
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
                                    <div class="paginating-container">{{ $promotion->appends(Request::only('search'))->links() }}</div>
                                </div>
                                @endif
                            </div>