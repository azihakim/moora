<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Penilaian PDF</title>
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
			margin-bottom: 20px;
		}

		table,
		th,
		td {
			border: 1px solid black;
		}

		th,
		td {
			padding: 8px;
			text-align: center;
		}

		th {
			background-color: #f2f2f2;
		}

		.header {
			text-align: center;
			margin-bottom: 20px;
		}

		.periode {
			font-weight: bold;
			margin-top: 20px;
		}
	</style>
</head>

<body>
	<div class="header">
		<h1>Penilaian Karyawan</h1>
	</div>

	@foreach ($data as $periode => $penilaianPeriode)
		<div class="periode">
			<h3>Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h3>
		</div>
		<table>
			<thead>
				<tr>
					<th>Kode</th>
					<th>Nama Alternatif</th>
					@foreach ($penilaianPeriode->unique('id_kriteria') as $penilaian)
						<th>{{ $penilaian->kriteria->kode_kriteria }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($penilaianPeriode->unique('id_user') as $index => $penilaian)
					<tr>
						{{-- <td>{{ $loop->iteration }}</td> --}}
						<td>{{ $penilaian->user->kode_alternatif }}</td>
						<td>{{ $penilaian->user->name }}</td>
						@foreach ($penilaianPeriode->where('id_user', $penilaian->user->id) as $userPenilaian)
							<td>
								@if ($userPenilaian->kriteria->kode_kriteria == 'C6')
									@if ($userPenilaian->nilai < 1)
										<!-- Untuk nilai kurang dari 1 -->
										<span> &lt; 1 Tahun</span>
									@elseif ($userPenilaian->nilai >= 1 && $userPenilaian->nilai < 3)
										<!-- Untuk nilai antara 1 dan 3 -->
										<span> ≥ 1 Tahun</span>
									@elseif ($userPenilaian->nilai >= 3 && $userPenilaian->nilai < 5)
										<!-- Untuk nilai antara 3 dan 5 -->
										<span> ≥ 3 Tahun</span>
									@else
										<!-- Untuk nilai lebih besar atau sama dengan 5 -->
										<span> ≥ 5 Tahun</span>
									@endif
								@else
									<!-- Jika kriteria bukan 'C6', tampilkan nilai biasa -->
									{{ $userPenilaian->nilai }}
								@endif
							</td>
						@endforeach
					</tr>
				@endforeach

			</tbody>
		</table>
	@endforeach

</body>

</html>
