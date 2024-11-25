@extends('layouts.index')
@section('styles')
@endsection
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Form Penilaian Perbulan</h1>
		</div>
		<!-- Content Row -->
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="card">
					<div class="card-body">
						<form action="{{ route('penilaianPerbulan.store') }}" method="POST">
							<div class="modal-body">
								@csrf
								<div class="form-group">
									<label>Tanggal Penilaian</label>
									<input type="month" name="tanggal_penilaian" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Karyawan</label>
									@if ($userById)
										<select name="karyawan" class="form-control">
											<option value="{{ $userById->id }}" selected>{{ $userById->name }} ({{ $userById->kode_alternatif }})
											</option>
										</select>
										<input type="hidden" name="formUserById" value="True">
									@else
										<select name="karyawan" class="form-control select2">
											<option value="" disabled selected>Pilih Karyawan</option>
											@foreach ($user as $u)
												<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->kode_alternatif }})</option>
											@endforeach
										</select>
									@endif

								</div>

								<div class="row">
									@foreach ($kriteria as $k)
										<div class="col-sm-6">
											<div class="form-group">
												<label>{{ $k->nama_kriteria }}</label>
												<input type="number" name="penilaian[{{ $k->id }}]" class="form-control" required value="1">
											</div>
										</div>
									@endforeach
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<a class="btn btn-danger" href="{{ route('penilaianPerbulan.index') }}">Kembali</a>
								<button class="btn btn-primary">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$('form').on('submit', function(e) {
			e.preventDefault(); // Mencegah submit form secara default

			let form = $(this);
			let formData = form.serialize(); // Ambil data form

			// Kirim data ke server menggunakan AJAX
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: formData,
				success: function(response) {
					if (response.status === 'confirm') {
						// Tampilkan dialog konfirmasi jika data sudah ada
						Swal.fire({
							title: 'Konfirmasi',
							text: response.message ||
								'Data sudah ada. Apakah Anda ingin memperbarui?',
							icon: 'warning',
							showCancelButton: true,
							confirmButtonText: 'Ya, perbarui',
							cancelButtonText: 'Batal',
						}).then((result) => {
							if (result.isConfirmed) {
								// Kirim ulang dengan konfirmasi
								$.ajax({
									url: form.attr('action'),
									method: form.attr('method'),
									data: formData +
										'&confirm=true', // Tambahkan flag konfirmasi
									success: function(res) {
										if (res.redirect_url) {
											Swal.fire({
												title: 'Sukses',
												text: res.message ||
													'Penilaian berhasil diperbarui!',
												icon: 'success',
											}).then(() => {
												window.location.href = res
													.redirect_url;
											});
										}
									},
									error: function(err) {
										const errorMessage = err.responseJSON
											?.message || 'Terjadi kesalahan.';
										Swal.fire('Error', errorMessage, 'error');
									},
								});
							}
						});
					} else if (response.redirect_url) {
						Swal.fire({
							title: 'Sukses',
							text: response.message || 'Penilaian berhasil disimpan!',
							icon: 'success',
						}).then(() => {
							window.location.href = response.redirect_url;
						});
					}
				},
				error: function(err) {
					const errorMessage = err.responseJSON?.message || 'Terjadi kesalahan.';
					Swal.fire('Error', errorMessage, 'error');
				},
			});
		});
	</script>
@endsection
