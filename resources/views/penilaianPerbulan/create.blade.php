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
									<input type="date" name="tanggal_penilaian" class="form-control">
								</div>
								<div class="form-group">
									<label>Karyawan</label>
									<select name="karyawan" class="form-control select2">
										<option value="" disabled selected>Pilih Karyawan</option>
										@foreach ($user as $u)
											<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->kode_alternatif }})</option>
										@endforeach
									</select>
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
@endsection
