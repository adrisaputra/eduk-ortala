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
					<th rowspan=2>File</th>
					<th rowspan=2></th>
				@else
					@if($parent_unit_id != 100)
						<th rowspan=2>File</th>
					@endif
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
						@if($v->file)
							<a href="{{ asset('upload/presence_recapitulation/'.$v->file) }}" target="_blank" class="btn mb-2 mr-1 btn-info">Lihat File</a>
						@endif
					</td>
					<td>
						<a href="{{ url('/presence_recapitulation/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
						</a>
						<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
					</td>
				@else
					@if($parent_unit_id != 100)
						<td>
							@if($v->file)
								<a href="{{ asset('upload/presence_recapitulation/'.$v->file) }}" target="_blank" class="btn mb-2 mr-1 btn-info">Lihat File</a>
							@endif
						</td>
					@endif
				@endif
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $presence_recapitulation->appends(Request::only('search'))->links() }}</div>
</div>