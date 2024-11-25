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
											<button class="btn btn-sm btn-danger btn_delete" data-id='{{ $u->id }}'>Delete</button>
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
				form.find('input[name=name]').val(data.name)
				form.find('input[name=tgl_masuk]').val(data.tgl_masuk)
				form.find('input[name=username]').val(data.username)
				form.find('input[name=kode_alternatif]').val(data.kode_alternatif)
				form.find('select[name=role]').val(data.role)

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
