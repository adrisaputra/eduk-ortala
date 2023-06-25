<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Nama Jabatan</th>
				<th>Jenis Jabatan</th>
			</tr>
		</thead>
		<tbody>
		@foreach($position as $v)
			<tr onclick="selectRow(this)">
				<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($position ->currentpage()-1) * $position ->perpage() + $loop->index + 1 }}</td>
				<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td id="position-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->type }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $position->appends(Request::only('search'))->links() }}</div>
	</div>
</div>