<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Jenis Cuti</th>
				<th>Deskripsi</th>
				<th>Status</th>
				<th>Tanggal Mulai</th>
				<th>Tanggal Selesai</th>
			</tr>
		</thead>
		<tbody>
		@foreach($leave_history as $v)
			<tr onclick="selectRow(this)">
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($leave_history ->currentpage()-1) * $leave_history ->perpage() + $loop->index + 1 }}</td>
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->type }}</td>
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->info }}</td>
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->status }}</td>
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->date_start }}</td>
				<td id="leave_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->date_finish }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $leave_history->appends(Request::only('search'))->links() }}</div>
	</div>
</div>