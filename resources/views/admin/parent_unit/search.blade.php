<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 2%">No</th>
				<th>Nama Unor Induk</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		@foreach($parent_unit as $v)
			<tr onclick="selectRow(this)">
				<td id="parent_unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($parent_unit ->currentpage()-1) * $parent_unit ->perpage() + $loop->index + 1 }}</td>
				<td id="parent_unit-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->name }}</td>
				<td class="col-md-3">
					<a href="{{ url('/parent_unit/edit/'.Crypt::encrypt($v->id)) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Lihat Pengajuan">Lihat Pengajuan</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $parent_unit->appends(Request::only('search'))->links() }}</div>
	</div>
</div>