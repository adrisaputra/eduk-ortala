<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Kode Golongan</th>
				<th>Golongan</th>
				<th>Pangkat</th>
			</tr>
		</thead>
		<tbody>
		@foreach($classes as $v)
			<tr onclick="selectRow(this)">
				<td id="classes-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($classes ->currentpage()-1) * $classes ->perpage() + $loop->index + 1 }}</td>
				<td id="classes-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->code }}</td>
				<td id="classes-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->class }}</td>
				<td id="classes-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->rank }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $classes->appends(Request::only('search'))->links() }}</div>
	</div>
</div>