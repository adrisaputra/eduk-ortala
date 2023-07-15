<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%" rowspan=2>No</th>
				<th rowspan=2>NIP</th>
				<th rowspan=2>Nama</th>
				<th colspan=2>Pangkat</th>
				<!-- <th rowspan=2>Unor</th> -->
				<th rowspan=2>Unor Induk</th>
				<th rowspan=2>Status Pegawai</th>
			</tr>
			<tr>
				<th>Gol.</th>
				<th>TMT</th>
			</tr>
		</thead>
		<tbody>
		@foreach($employee as $v)
			<tr onclick="selectRow(this)">
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($employee ->currentpage()-1) * $employee ->perpage() + $loop->index + 1 }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->front_title }} {{ $v->name }} {{ $v->back_title }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->classes ? $v->classes->class : '' }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->classes && $v->classes->class_history($v->nip)->first() ? date('d-m-Y', strtotime($v->classes->class_history($v->nip)->first()->tmt)) : '' }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->parent_unit ? $v->parent_unit->name : '' }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->status }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $employee->appends(Request::only('search','parent_unit_id'))->links() }}</div>
	</div>
</div>