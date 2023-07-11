<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>NIP</th>
				<th>Unit Kerja</th>
				<th>Jenis Jabatan</th>
				<th>Jabatan</th>
				<th>Eselon</th>
				<th>TMT. Jabatan</th>
				<th>No. SK</th>
				<th>Tgl SK</th>
				<!-- <th>Pejabat</th>
				<th>Status Sumpah</th> -->
			</tr>
		</thead>
		<tbody>
		@foreach($position_history as $v)
			<tr onclick="selectRow(this)">
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($position_history ->currentpage()-1) * $position_history ->perpage() + $loop->index + 1 }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->unit }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->position_type }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->position }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->eselon }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->tmt }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sk_number }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sk_date }}</td>
				<!-- <td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->official_name }}</td>
				<td id="position_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sworn_status }}</td> -->
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $position_history->appends(Request::only('search'))->links() }}</div>
	</div>
</div>