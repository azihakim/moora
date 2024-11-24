@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Perhitungan</h1>
		</div>
		<!-- Content Row -->
		<div class="row mb-4">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<h4>Periode Perhitungan</h4>
						</div>
					</div>
					<div class="card-body">
						<form id="countMoora">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Tanggal Dari</label>
										<input type="date" name="tgl_dari" class="form-control" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Tanggal Sampai</label>
										<input type="date" name="tgl_sampai" class="form-control" required>
									</div>
								</div>
								<div class="col-sm-2">
									<button class="btn btn-primary" style="margin-top: 30px">Hitung</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		{{-- <div class="row">
			<table class="table">
				<thead>
					<tr>
						<td>nama</td>
						<td>kriteria</td>
						<td>hasil</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $item)
						<tr>
							<td>{{ $item->user->name }}</td>
							<td>{{ $item->kriteria->nama_kriteria }}</td>
							<td>{{ $item->sub_kriteria ? $item->sub_kriteria->nama_sub_kriteria : 'Tidak Ada' }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> --}}
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			$('button').click(function() {
				var tgl_dari = $('input[name="tgl_dari"]').val();
				var tgl_sampai = $('input[name="tgl_sampai"]').val();
				if (tgl_dari == '' || tgl_sampai == '') {
					alert('Tanggal Dari dan Tanggal Sampai harus diisi');
				} else {
					$.ajax({
						url: '{{ url('countPenilaianPerbulan') }}/' + tgl_dari + '/' + tgl_sampai,
						type: 'POST',
						data: {
							_token: '{{ csrf_token() }}',
							tgl_dari: tgl_dari,
							tgl_sampai: tgl_sampai
						},
						success: function(data) {
							if (data.status == 'success') {
								alert('Perhitungan berhasil');
							} else {
								alert('Perhitungan gagal');
							}
						}
					});
				}
			});
		});
	</script>
@endsection
