<div id="hasil">
	<div class="table-responsive">
	<table class="table table-bordered table-hover mb-4">
		<thead>
			<tr>
				<th style="width: 60px">No</th>
				<th>Eksekutor</th>
				<th>Deskripsi</th>
				<th>Waktu Eksekusi</th>
				<th style="width: 20%">#aksi</th>
			</tr>
		</thead>
		<tbody>
		@foreach($log as $v)
			<tr>
				<td id="log-{{ $v->id }}" onClick="getLog(this.id)">{{ ($log ->currentpage()-1) * $log ->perpage() + $loop->index + 1 }}</td>
				<td id="log-{{ $v->id }}" onClick="getLog(this.id)">{{ $v->user ? $v->user->name : '' }} </td>
				<td id="log-{{ $v->id }}" onClick="getLog(this.id)">{{ $v->description }}</td>
				<td id="log-{{ $v->id }}" onClick="getLog(this.id)">{{ \Carbon\Carbon::parse($v->created_at)->diffForHumans(); }}</td>
				<td id="log-{{ $v->id }}" onClick="getLog(this.id)"><a href="#" class="btn btn-sm btn-info"><i class="fa fa-list"></i>Detail</a></td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="paginating-container">{{ $log->appends(Request::only('search'))->links() }}</div>
	</div>
</div>