@extends('layouts.index')
@section('content')
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Rekap</h1>
		</div>

		<!-- Content Row -->
		<div class="row">
			<div class="col-sm-12">

				@if (session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
					</div>
					<script>
						document.addEventListener("DOMContentLoaded", function() {
							setTimeout(function() {
								let alert = document.querySelector('.alert-success');
								if (alert) {
									alert.classList.remove('show');
									alert.addEventListener('transitionend', function() {
										alert.remove();
									});
								}
							}, 2000);
						});
					</script>
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
						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th style="width: 5%">No</th>
									<th style="width:40%">Periode</th>
									<th style="width:30%">Rekap</th>
									@if (auth()->user()->role == 'Direktur')
										<th style="width:5%">Status</th>
										<th style="width:5%">Validasi</th>
									@endif
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
											@if (auth()->user()->role == 'HRD' || auth()->user()->role == 'Direktur')
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
										@if (auth()->user()->role == 'Direktur')
											<td>
												@if ($item->status == 1)
													<span class="badge badge-success">Tervalidasi</span>
												@else
													<span class="badge badge-danger">Tidak Valid</span>
												@endif
											</td>
											<td>

												<form action="{{ route('rekap.updateStatus', $item->id) }}" method="POST" class="d-inline">
													@csrf
													@method('PUT')
													<select class="btn btn-sm btn-outline-danger mr-2" name="status" onchange="this.form.submit()">
														<option selected disabled>Validasi</option>
														<option value="1">Iya</option>
														<option value="0">Tidak</option>
													</select>
												</form>
											</td>
										@endif
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
