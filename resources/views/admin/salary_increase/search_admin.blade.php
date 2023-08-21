<div id="hasil">
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-4">
            <thead>
                <tr>
                    <th style="width: 2%">No</th>
                    <th>NIP/Nama</th>
                    <th>Gaji Lama</th>
                    <th>Gaji Baru</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @php $total = 0; $i = 0;@endphp
            @foreach($salary_increase as $v)
            @php $i = $i+1; @endphp
                <tr>
                    <td class="text-center">{{ ($salary_increase ->currentpage()-1) * $salary_increase ->perpage() + $loop->index + 1 }}</td>
                    <td style="width:30%">NIP : {{ $v->employee->nip }}<br>{{ $v->employee->front_title }} {{ $v->employee->name }} {{ $v->employee->back_title }}</td>
                    <td style="width:14%">Rp. {{ number_format($v->old_salary, 0, ',', '.') }}</td>
                    <td style="width:14%">Rp. {{ number_format($v->new_salary, 0, ',', '.') }}</td>
                    <td style="width:14%">
                    @if($v->status=="Dikirim")
                        @if($v->note)
                            <span class="badge badge-primary">Sudah Diperbaiki</span><br><br>
                            Note :<br> {{ $v->note }}
                        @else
                            <span class="badge badge-primary">Dokumen Masuk</span>
                        @endif
                    @elseif($v->status=="Diperbaiki")
                        <span class="badge badge-info">Dokumen Salah</span><br><br>
                        Note :<br> {{ $v->note }}
                    @elseif($v->status=="Diterima")
                        <span class="badge badge-success">Terverifikasi</span>
                    @endif
                    </td>
                    <td class="col-md-2">
                        @if($v->status=="Dikirim")
                            <a href="{{ url('/salary_increase_file/'.Crypt::encrypt($v->id)) }}" class="btn mb-2 mr-1 btn-success btn-sm">Verifikasi</a>
                        @elseif($v->status=="Diterima")
                            <a href="{{ url('salary_increase/print/'.Crypt::encrypt($v->id))}}" class="btn mr-1 btn-info btn-sm">Cetak KGB</a>		
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="paginating-container">{{ $salary_increase->appends(Request::only('search'))->links() }}</div>
    </div>
                            </div>