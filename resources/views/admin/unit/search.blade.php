<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Kode Unor</th>
				<th>Nama Unor</th>
				<th>Unor Induk</th>
				<th>Unor Atasan</th>
			</tr>
		</thead>
		<tbody>
		@foreach($unit as $v)
			<tr onclick="selectRow(this)">
				<td id="unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($unit ->currentpage()-1) * $unit ->perpage() + $loop->index + 1 }}</td>
				<td id="unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->code }}</td>
				<td id="unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td id="unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->parent_code }}</td>
				<td id="unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->leader_code }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $unit->appends(Request::only('search'))->links() }}</div>
	</div>
</div>