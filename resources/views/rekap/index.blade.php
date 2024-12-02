@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Rekap</h1>
		</div>

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
									<th style="width: 5%">No</th>
									<th>Periode</th>
									<th style="width:50%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 1;
								@endphp
								@foreach ($data as $item)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ \Carbon\Carbon::parse(explode(' / ', $item->periode)[0])->translatedFormat('F Y') }} -
											{{ \Carbon\Carbon::parse(explode(' / ', $item->periode)[1])->translatedFormat('F Y') }}</td>
										<td>
											@if (auth()->user()->role == 'HRD')
												{{-- <a class="btn btn-sm btn-info" href="{{ asset('storage/' . $item->rekap_pdf) }}" download>Download
													Rekapan</a> --}}
												<a class="btn btn-sm btn-info mr-2" href="{{ route('rekapHrd', $item->id) }}">Rekapan Perhitungan</a>
												<a class="btn btn-sm btn-primary" href="{{ route('rekapPerbulan', $item->id) }}">Rekapan
													Perbulan</a>
											@else
												{{-- <a class="btn btn-sm btn-primary" href="{{ asset('storage/' . $item->rekap_perbulan_pdf) }}" download>Rekapan
													Perbulan</a> --}}
												<a class="btn btn-sm btn-info mr-2" href="{{ route('rekapHrd', $item->id) }}">Rekapan Perhitungan</a>
											@endif

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
@endpush
