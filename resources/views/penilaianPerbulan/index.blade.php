@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Penilaian Perbulan</h1>
		</div>

		<a class="btn btn-primary mb-3" href="{{ route('penilaianPerbulan.create') }}">Tambah Penilain Perbulan</a>
		<!-- Content Row -->
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Alternatif</th>
									<th>Nama Alternatif</th>
									<th style="width:128px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 1;
								@endphp
								@foreach ($users as $u)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $u->kode_alternatif }}</td>
										<td>{{ $u->name }}</td>
										<td>
											<a class="btn btn-sm btn-warning btn_edit">Edit</a>
											{{-- @if ($u->penilaian()->count() > 0)
												<button class="btn btn-sm btn-warning btn_edit" data-data='{{ $u }}'
													data-penilaian='{{ $u->penilaian }}'>Edit</button>
											@else
												<button class="btn btn-sm btn-success btn_input" data-data='{{ $u }}'>Input</button>
											@endif --}}
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
@endpush
