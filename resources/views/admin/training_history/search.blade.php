<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Nama Diklat</th>
				<th>Tempat</th>
				<th>Penyelenggara</th>
				<th>Angkatan</th>
				<th>Tanggal Mulai</th>
				<th>Tanggal Selesai</th>
				<th>Jumlah Jam</th>
			</tr>
		</thead>
		<tbody>
		@foreach($training_history as $v)
			<tr onclick="selectRow(this)">
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($training_history ->currentpage()-1) * $training_history ->perpage() + $loop->index + 1 }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->place }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->organizer }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->generation }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->start }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->finish }}</td>
				<td id="training_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->hours }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $training_history->appends(Request::only('search'))->links() }}</div>
	</div>
</div>