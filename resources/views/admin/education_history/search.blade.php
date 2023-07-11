<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>NIP</th>
				<th>Nama Pejabat</th>
				<th>No. Ijazah</th>
				<th>Tanggal. Ijazah</th>
				<th>Nama Sekolah</th>
			</tr>
		</thead>
		<tbody>
		@foreach($education_history as $v)
			<tr onclick="selectRow(this)">
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($education_history ->currentpage()-1) * $education_history ->perpage() + $loop->index + 1 }}</td>
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->official_name }}</td>
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->diploma_number }}</td>
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->diploma_date }}</td>
				<td id="education_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->school_name }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $education_history->appends(Request::only('search'))->links() }}</div>
	</div>
</div>