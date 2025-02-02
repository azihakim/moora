@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Pegawai</h1>
		</div>
		<!-- Content Row -->
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary mb-3" id="btn_add">Tambah Pegawai</button>
				<div class="card">
					<div class="card-body">
						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Kode Alternatif</th>
									<th>Username</th>
									<th>Jabatan</th>
									<th style="width:128px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $u)
									<tr>
										<td>{{ $u->name }}</td>
										<td>{{ $u->kode_alternatif ?: '-' }}</td>
										<td>{{ $u->username }}</td>
										<td>{{ $u->role }}</td>
										<td>
											<button class="btn btn-sm btn-warning btn_edit" data-data='{{ $u }}'>Edit</button>
											{{-- <button class="btn btn-sm btn-danger btn_delete" data-id='{{ $u->id }}'>Delete</button> --}}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('users.add_modal')
	@include('users.edit_modal')
	@include('users.delete_modal')
@endsection

@push('scripts')
	<script>
		$(document).ready(function() {
			$('#btn_add').on('click', function() {
				// Panggil endpoint untuk mendapatkan kode alternatif
				$.ajax({
					url: '/get-kode-user',
					type: 'GET',
					dataType: 'json',
					success: function(data) {
						if (data.kode_alternatif) {
							// Isi kolom kode alternatif di modal jika respon berhasil
							$('#kode_alternatif').val(data.kode_alternatif);
						} else {
							// Jika tidak ada data, set default A1
							$('#kode_alternatif').val('A1');
						}
						// Tampilkan modal
						$('#modalUser').modal('show');
					},
					error: function(xhr, status, error) {
						console.error('Terjadi kesalahan:', error);
						// Jika terjadi error, fallback ke A1
						$('#kode_alternatif').val('A1');
						$('#modalUser').modal('show');
					}
				});
			});

			// Submit form user (opsional)
			$('#formUser').on('submit', function(e) {
				e.preventDefault();
				// Lakukan sesuatu dengan data form
				console.log($(this).serialize());
			});
		});
	</script>
	<script>
		$(function() {
			$('#dataTable').DataTable();
			$('#btn_add').on('click', function() {
				$("#add_form").modal('show')
			})
			$(".btn_edit").on('click', function() {
				const data = $(this).data('data')
				const form = $("#edit_form form")
				$("#edit_form").modal('show')
				form.attr('action', '{{ route('users.index') }}/' + data.id)
				form.find('input[name=name]').val(data.name);
				form.find('input[name=tgl_masuk]').val(data.tgl_masuk);
				form.find('input[name=username]').val(data.username);
				form.find('input[name=no_hp]').val(data.no_hp);
				form.find('input[name=alamat]').val(data.alamat);
				form.find('input[name=nik]').val(data.nik);
				form.find('select[name=jenis_kelamin]').val(data.jenis_kelamin);
				form.find('select[name=agama]').val(data.agama);
				form.find('select[name=role]').val(data.role);
				form.find('input[name=kode_alternatif]').val(data.kode_alternatif);

				if (form.find("select[name=role]").val() == "Pegawai") {
					form.find("input[name=kode_alternatif]").parent().show()
				} else {
					form.find("input[name=kode_alternatif]").parent().hide()
				}
			})
			$(".btn_delete").on('click', function() {
				const id = $(this).data('id')
				$("#delete_modal").modal('show')
				$("#delete_form").attr('action', '{{ route('users.index') }}/' + id)
			})

			$("select[name=role]").on('change', function() {
				if ($(this).val() === "Pegawai") {
					$("input[name=kode_alternatif]").parent().show()
				} else {
					$("input[name=kode_alternatif]").parent().hide()
				}
			})
		});
	</script>

	@if ($errors->any())
		<script>
			console.log('Validation Errors..')
		</script>
		@if (session()->get('method') === 'store')
			<script>
				$("#add_form").modal('show')
			</script>
		@endif
		@if (session()->get('method') === 'update')
			<script>
				$("#edit_form").modal('show')
				$("#edit_form form").attr('action', '{{ route('users.index') }}/' + '{{ session()->get('id') }}')
			</script>
		@endif
	@endif
@endpush
