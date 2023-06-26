<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Kode Pendidikan</th>
				<th>Nama Pendidikan</th>
				<th>Kode Tingkat</th>
			</tr>
		</thead>
		<tbody>
		@foreach($education as $v)
			<tr onclick="selectRow(this)">
				<td id="education-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($education ->currentpage()-1) * $education ->perpage() + $loop->index + 1 }}</td>
				<td id="education-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->code }}</td>
				<td id="education-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td id="education-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->level_code }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $education->appends(Request::only('search'))->links() }}</div>
	</div>
</div>