
<div id="hasil">
	<div class="table-responsive">
		<table class="table table-bordered table-hover mb-4">
			<thead>
				<tr>
					<th style="width: 2%">No</th>
					<th>Nama User</th>
					<th>Email</th>
					<th>Group</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($user as $v)
				<tr>
					<td class="text-center">{{ ($user ->currentpage()-1) * $user ->perpage() + $loop->index + 1 }}</td>
					<td style="width:40%">{{ $v->name }}</td>
					<td style="width:40%">{{ $v->email }}</td>
					<td>@if($v->group_id==1)
						<span class="badge badge-info">Administrator</span>
						@elseif($v->group_id==2)
							<span class="badge badge-primary">Admin Biro</span>
						@elseif($v->group_id==3)
							<span class="badge badge-warning">Tamu</span>
						@endif
					</td>
					<td>@if($v->status==0)
						<span class="badge badge-danger">Tidak Aktif</span>
						@elseif($v->status==1)
						<span class="badge badge-success">Aktif</span>
						@endif
					</td>
					<td class="col-md-3">
						@can('ubah-data')
							<a href="{{ url('/user/edit/'.$v->id) }}" class="btn mb-2 mr-1 btn-sm btn-warning snackbar-bg-warning btn-block">Edit</href><br>
						@endcan
						@if($v->id !=1)
							@can('hapus-data')
								<a href="#" class="btn mb-2 mr-1 btn-sm btn-danger snackbar-bg-danger btn-block warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}">Hapus</href>
							@endcan
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="paginating-container">{{ $user->appends(Request::only('search'))->links() }}</div>
	</div>
</div>