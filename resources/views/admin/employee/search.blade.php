<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Status Pegawai</th>
				<th>Unor</th>
			</tr>
		</thead>
		<tbody>
		@foreach($employee as $v)
			<tr onclick="selectRow(this)">
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($employee ->currentpage()-1) * $employee ->perpage() + $loop->index + 1 }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->status }}</td>
				<td id="employee-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->unit->name }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $employee->appends(Request::only('search'))->links() }}</div>
	</div>
</div>