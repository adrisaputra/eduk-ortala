<div id="hasil">
									<div class="table-responsive">
									<table class="table table-bordered table-hover mb-4">
										<thead>
											<tr>
												<th style="width: 2%">No</th>
												<th>NIP</th>
												<th>Tanggal</th>
												<th>Waktu Masuk</th>
												<th>Waktu Pulang</th>
												<th>Kategori Absen</th>
											</tr>
										</thead>
										<tbody>
										@foreach($absence_history as $v)
											<tr onclick="selectRow(this)">
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ ($absence_history ->currentpage()-1) * $absence_history ->perpage() + $loop->index + 1 }}</td>
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->nip }}</td>
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->date }}</td>
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->in }}</td>
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->out }}</td>
												<td id="absence_history-{{ $v->id }}" onClick="getEmployee(this.id)">{{ $v->in_type }}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
									<div class="paginating-container">{{ $absence_history->appends(Request::only('search'))->links() }}</div>
									</div>
								</div>