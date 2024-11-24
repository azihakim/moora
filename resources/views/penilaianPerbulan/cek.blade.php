@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Penilaian Perbulan {{ $user->name }} ({{ $user->kode_alternatif }})</h1>
		</div>

		<a class="btn btn-primary mb-3" href="{{ route('penilaianPerbulan.createByUser', $user->id) }}">Tambah Penilaian
			Perbulan</a>
		<!-- Content Row -->
		<div class="row">
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
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th style="width:0%">No</th>
									<th>Periode</th>
									<th style="width:128px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 1;
								@endphp
								@foreach ($penilaian as $p)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ \Carbon\Carbon::parse($p->periode)->format('d F Y') }}</td> <!-- This is the formatted periode -->
										<td>
											<!-- Pass the raw periode to the URL -->
											<a class="btn btn-sm btn-warning"
												href="{{ url('penilaianPerbulan/' . $p->periode . '/' . $p->id_user . '/edit') }}">Edit</a>
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
@endsection

@push('scripts')
	<script>
		$(function() {
			$('#dataTable').DataTable();
		});
	</script>

	<script>
		$(document).ready(function() {
			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 3000);
		});
	</script>
@endpush
