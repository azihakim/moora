@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Kriteria</h1>
		</div>
		<!-- Content Row -->
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary mb-3" id="btn_add">Tambah Kriteria</button>
				<div class="card">
					<div class="card-body">
						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th>Kode Kriteria</th>
									<th>Nama Kriteria</th>
									<th>Bobot</th>
									<th>Jenis</th>
									<th style="width:128px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($kriteria as $k)
									<tr>
										<td>{{ $k->kode_kriteria }}</td>
										<td>{{ $k->nama_kriteria }}</td>
										<td>{{ $k->bobot }}</td>
										<td>{{ $k->jenis }}</td>
										<td>
											<button class="btn btn-sm btn-warning btn_edit" data-data='{{ $k }}'>Edit</button>
											{{-- <button class="btn btn-sm btn-danger btn_delete"
                                                data-id='{{ $k->id }}'>Delete</button> --}}
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

	@include('kriteria.add_modal')
	@include('kriteria.edit_modal')
	@include('kriteria.delete_modal')
@endsection

@push('scripts')
	<script>
		$(document).ready(function() {
			$('#btn_add').on('click', function() {
				// Panggil endpoint untuk mendapatkan kode kriteria
				$.ajax({
					url: '/get-kode-kriteria',
					type: 'GET',
					dataType: 'json',
					success: function(data) {
						// Isi kolom kode kriteria di modal
						$('#kode_kriteria').val(data.kode_kriteria);
						// Tampilkan modal
						$('#modalKriteria').modal('show');
					},
					error: function(xhr, status, error) {
						console.error('Terjadi kesalahan:', error);
					}
				});
			});

			// Submit form (opsional, jika ada)
			$('#formKriteria').on('submit', function(e) {
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
				form.attr('action', '{{ route('kriteria.index') }}/' + data.id)
				form.find('input[name=kode_kriteria]').val(data.kode_kriteria)
				form.find('input[name=nama_kriteria]').val(data.nama_kriteria)
				form.find('input[name=bobot]').val(data.bobot)
				form.find('select[name=jenis]').val(data.jenis)
			})
			$(".btn_delete").on('click', function() {
				const id = $(this).data('id')
				$("#delete_modal").modal('show')
				$("#delete_form").attr('action', '{{ route('kriteria.index') }}/' + id)
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
				$("#edit_form form").attr('action', '{{ route('kriteria.index') }}/' + '{{ session()->get('id') }}')
			</script>
		@endif
	@endif
@endpush
