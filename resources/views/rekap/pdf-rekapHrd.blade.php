<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hasil Rekap Penilaian</title>
	<style>
		body {
			font-family: 'DejaVu Sans', sans-serif;
			font-size: 12px;
			margin: 20px;
			color: #333;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		table,
		th,
		td {
			border: 1px solid #ddd;
		}

		th,
		td {
			padding: 8px;
			text-align: center;
		}

		th {
			background-color: #f9f9f9;
			font-weight: bold;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
	</style>

</head>

<body>
	<h2 style="text-align: center;">Hasil Rekap Penilaian</h2>
	<h3 style="text-align: center;">Periode: {{ \Carbon\Carbon::parse($tglDari)->translatedFormat('F Y') }} -
		{{ \Carbon\Carbon::parse($tglSampai)->translatedFormat('F Y') }}</h3>
	<table>
		<thead>
			<tr>
				<th>Rank</th>
				<th>Kode Alternatif</th>
				<th>Nama Alternatif</th>
				@foreach ($data['kriteria'] as $kriteria)
					<th>{{ $kriteria['kode_kriteria'] }} ({{ $kriteria['nama_kriteria'] }})</th>
				@endforeach
				<th>Nilai Yi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['nilai_yi'] as $index => $yi)
				<tr>
					<td>{{ $index + 1 }}</td>
					<td>{{ $yi['kode_alternatif'] }}</td>
					<td>{{ $yi['nama_alternatif'] }}</td>

					{{-- Looping untuk menampilkan nilai dari matriks_keputusan --}}
					@foreach ($data['matriks_keputusan'] as $matriks)
						@if ($matriks['kode_alternatif'] == $yi['kode_alternatif'])
							@foreach ($matriks['nilai'] as $index => $nilai)
								<td>
									@if ($data['kriteria'][$index]['kode_kriteria'] == 'C6')
										{{-- Tampilan khusus untuk C1 (misalnya Kualitas Kerja) --}}
										@if ($nilai[0] == 1)
											≤ 1 Tahun
										@elseif ($nilai[0] == 2)
											> 1 Tahun
										@elseif ($nilai[0] == 3)
											≤ 3 Tahun
										@elseif ($nilai[0] == 4)
											> 5 Tahun
										@endif
									@else
										{{-- Default untuk alternatif lain --}}
										@if ($nilai[0] == 1)
											Kurang
										@elseif ($nilai[0] == 2)
											Cukup
										@elseif ($nilai[0] == 3)
											Baik
										@elseif ($nilai[0] == 4)
											Sangat Baik
										@else
											{{ $nilai[0] }} hari
										@endif
									@endif
								</td>
							@endforeach
						@endif
					@endforeach


					{{-- Nilai Yi --}}
					<td>{{ number_format($yi['yi'], 4, ',', '.') }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>
