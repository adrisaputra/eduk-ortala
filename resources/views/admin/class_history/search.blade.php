<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>NIP</th>
				<th>Pangkat</th>
				<th>Golongan</th>
				<th>TMT Pangkat</th>
				<th>SK. Pejabat</th>
				<th>No. SK</th>
				<th>Tanggal. SK</th>
				<th>Masa Kerja Tahun</th>
				<th>Masa Kerja Bulan</th>
			</tr>
		</thead>
		<tbody>
		@foreach($class_history as $v)
			<tr onclick="selectRow(this)">
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($class_history ->currentpage()-1) * $class_history ->perpage() + $loop->index + 1 }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->rank }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->class }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->tmt }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sk_official }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sk_number }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->sk_date }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->mk_year }}</td>
				<td id="class_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->mk_month }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $class_history->appends(Request::only('search'))->links() }}</div>
	</div>
</div>