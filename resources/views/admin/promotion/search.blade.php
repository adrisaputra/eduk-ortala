<div id="hasil">
	<div class="table-responsive">
		<table class="table table-bordered table-hover mb-4">
			<thead>
				<tr>
					<th style="width: 2%">No</th>
					<th>Nama</th>
					<th>File</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($constitution as $v)
				<tr>
					<td class="text-center">{{ ($constitution ->currentpage()-1) * $constitution ->perpage() + $loop->index + 1 }}</td>
					<td style="width:40%">{{ $v->name }}</td>
					<td><a href="{{ asset('upload/constitution/'.$v->file) }}" target="_blank" class="btn mb-2 mr-1 btn-info">Download File</a></td>
					<td class="col-md-3">
						<a href="{{ url('/constitution/edit/'.Crypt::encrypt($v->id)) }}" data-toggle="tooltip" data-placement="top" title="Edit">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
						</a>
						<a href="#" class="warning confirm" onclick="DeleteData(this.id)" id="{{ $v->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="paginating-container">{{ $constitution->appends(Request::only('search'))->links() }}</div>
	</div>
</div>