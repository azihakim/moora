<div class="row mb-4">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Matriks Keputusan</div>
			</div>
			<div class="card-body">
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th style="width:1%">No</th>
							<th style='width:200px'>Kode Alternatif</th>
							@foreach ($kriteria as $k)
								<th style="text-align: center">{{ $k->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@php
							$i = 1;
						@endphp
						@foreach ($matriks_keputusan as $mk)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $mk['kode_alternatif'] }}</td>
								@foreach ($mk['nilai'] as $n)
									<th style="text-align: center">{{ $n[0] }}</th>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Matriks Ternormalisasi</div>
			</div>
			<div class="card-body">
				<table class="table" id="dataTable2">
					<thead>
						<tr>
							<th style="width:1%">No</th>
							<th style='width:200px'>Kode Alternatif</th>
							@foreach ($kriteria as $k)
								<th style="text-align: center">{{ $k->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@php
							$i = 1;
						@endphp
						@foreach ($matriks_ternormalisasi as $mt)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $mt['kode_alternatif'] }}</td>
								@foreach ($mt['nilai'] as $n)
									<th style="text-align: center">{{ number_format($n[0], 4) }}</th>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Matriks Normalisasi Terbobot</div>
			</div>
			<div class="card-body">
				<table class="table" id="dataTable3">
					<thead>
						<tr>
							<th style="width:1%">No</th>
							<th style='width:200px'>Kode Alternatif</th>
							@foreach ($kriteria as $k)
								<th style="text-align: center">{{ $k->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@php
							$i = 1;
						@endphp
						@foreach ($matriks_normalisasi_terbobot as $mnt)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $mnt['kode_alternatif'] }}</td>
								@foreach ($mnt['nilai'] as $n)
									<th style="text-align: center">{{ number_format($n[0], 4) }}</th>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">Menghitung Nilai Yi</div>
			</div>
			<div class="card-body">
				<table class="table" id="dataTable4">
					<thead>
						<tr>
							<th style="width:1%">No</th>
							<th>Nama Alternatif</th>
							<th style="text-align: center">
								Max
								(@foreach ($kriteria as $k)
									@if ($k->jenis == 'Benefit')
										{{ $k->kode_kriteria }}
									@endif
								@endforeach)
							</th>
							<th style="text-align: center">
								Min
								(@foreach ($kriteria as $k)
									@if ($k->jenis == 'Cost')
										{{ $k->kode_kriteria }}
									@endif
								@endforeach)
							</th>
							<th style="text-align: center">Yi = Max - Min</th>
						</tr>
					</thead>
					<tbody>
						@php
							$i = 1;
						@endphp
						@foreach ($nilai_yi as $ny)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $ny['nama_alternatif'] }}</td>
								<td style="text-align: center">{{ number_format($ny['max'], 4) }}</td>
								<td style="text-align: center">{{ number_format($ny['min'], 4) }}</td>
								<td style="text-align: center">{{ number_format($ny['yi'], 4) }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
