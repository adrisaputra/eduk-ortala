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