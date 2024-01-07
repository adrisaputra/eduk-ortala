<html>
<head>
	<title>DATA PEGAWAI</title>
</head>
<style type="text/css">
		/* table tr td,
		table tr th{
			font-size: 9pt;
		} */
		table {
			border-collapse: collapse;
			border-spacing: 0;
			}
		table {
		background-color: transparent;
		}
		table col[class*="col-"] {
		position: static;
		display: table-column;
		float: none;
		}
		table td[class*="col-"],
		table th[class*="col-"] {
		position: static;
		display: table-cell;
		float: none;
		}
		.table {
		width: 100%;
		max-width: 100%;
		margin-bottom: 20px;
		}
		.table > thead > tr > th,
		.table > tbody > tr > th,
		.table > tfoot > tr > th,
		.table > thead > tr > td,
		.table > tbody > tr > td,
		.table > tfoot > tr > td {
		padding: 3px;
		line-height: 1.42857143;
		vertical-align: top;
		border-top: 1px solid #ddd;
		}
		.table > tbody + tbody {
		border-top: 2px solid #ddd;
		}
		.table .table {
		background-color: #fff;
		}
		
		.table-bordered {
		border: 1px solid #ddd;
		}
		
		.table-striped > tbody > tr:nth-of-type(odd) {
		background-color: #f9f9f9;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
		/* border: 1px solid #f4f4f4; */
		border: 1px solid #e1e1e1;
		}
		html {
			font-family: sans-serif;
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
		}
	</style>
	<style>
		.page-break {
		page-break-after: always;
		}
		.page-break2 {
		page-break-after: avoid;
		}
	</style>
<body>
	
<center>
	<p>	
		DAFTAR REKAPITULASI ABSENSI LAPANGAN (APEL/PAGI) ASN LINGKUP SETDA PROV. SULTRA<br>
		BULAN {{ $month_name }} TAHUN {{ $year }}
	</p>
</center>
@if($parent_unit_id != 100)
	<center><p>{{ $parent_unit->name }}</p></center>
@endif
<table class="table table-bordered" style="width : 100%; padding-top: -10px; height: 10px" >
	<thead>
		<tr style="background-color: gray;color:white">
			<th rowspan=2>No</th>
			<th rowspan=2>Hari/Tanggal</th>
			<th rowspan=2>Jumlah ASN</th>
			<th colspan=6>Laporan</th>
			<th rowspan=2>Ket</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>TL</th>
			<th>Cuti</th>
			<th>Sakit</th>
			<th>Hadir</th>
			<th>Tanpa Keterangan (Tidak Hadir)</th>
			<th>Rata-rata Hadir (%)</th>
		</tr>
	</thead>
	<tbody>
	@if($presence_recapitulation)
	@foreach($presence_recapitulation as $i => $v)
		<tr>
			<td class="text-center">{{ $i+1 }}</td>
			<td style="width:20%">{{ $v->day }}, {{ date('d-m-Y', strtotime($v->date)) }}</td>
			<td style="width:20%">{{ $v->employee_amount }}</td>
			<td>{{ $v->tl }}</td>
			<td>{{ $v->ct }}</td>
			<td>{{ $v->s }}</td>
			<td>{{ $v->h }}</td>
			<td>{{ $v->th }}</td>
			<td>
				@php
					$x = $v->h; 
					$persentase = ($x/$v->employee_amount)*100;
				@endphp
				{{ number_format($persentase, 2) }} %
			</td>
			<td>{{ $v->desc }}</td>
		</tr>
	@endforeach
	@endif
	</tbody>
</table>


</body>
</html>