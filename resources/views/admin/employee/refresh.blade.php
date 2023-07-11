@if($synchronization->status == "Process")
<div class="w-browser-details" id="synchronization">
	<div class="w-browser-info">
		<h6>Proses Sinkronisasi <b>({{ round($persentase) }}%)</b></h6>
	</div>
	<div class="w-browser-stats">
		<div class="progress">
			<div class="progress-bar bg-gradient-success" role="progressbar" style="background-image: linear-gradient(to right, #8BC34A 0%, #4CAF50 100%);width: {{ round($persentase) }}%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	</div>
</div>
@endif