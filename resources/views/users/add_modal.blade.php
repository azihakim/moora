<!-- Modal -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="add_formModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_formModalLabel">Form Tambah Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('users.store') }}" method="POST">
				<div class="modal-body">
					@csrf
					<div class="form-row">
						<div class="form-group col-sm-6">
							<label>Nama</label>
							<input type="text" name="name" class="form-control" placeholder="Masukkan Nama"
								value="{{ old('name') }}">
							<small class="text-danger">{{ $errors->first('name') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Tanggal Masuk</label>
							<input type="date" name="tgl_masuk" class="form-control" value="{{ old('tgl_masuk') }}">
							<small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>No Telepon</label>
							<input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
							<small class="text-danger">{{ $errors->first('no_hp') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Alamat</label>
							<input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
							<small class="text-danger">{{ $errors->first('alamat') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>NIK</label>
							<input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
							<small class="text-danger">{{ $errors->first('nik') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control">
								<option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
								<option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
							</select>
							<small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Agama</label>
							<select name="agama" class="form-control">
								<option value="Islam" {{ old('agama') === 'Islam' ? 'selected' : '' }}>Islam</option>
								<option value="Kristen" {{ old('agama') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
								<option value="Katolik" {{ old('agama') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
								<option value="Hindu" {{ old('agama') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
								<option value="Buddha" {{ old('agama') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
								<option value="Konghucu" {{ old('agama') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
							</select>
							<small class="text-danger">{{ $errors->first('agama') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Jabatan</label>
							<select name="role" class="form-control">
								<option value="Pegawai" {{ old('role') === 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
								<option value="HRD" {{ old('role') === 'HRD' ? 'selected' : '' }}>HRD</option>
								<option value="Direktur" {{ old('role') === 'Direktur' ? 'selected' : '' }}>Direktur</option>
							</select>
							<small class="text-danger">{{ $errors->first('role') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Kode Alternatif</label>
							<input type="text" name="kode_alternatif" class="form-control" placeholder="Masukkan Kode Alternatif"
								value="{{ old('kode_alternatif') }}">
							<small class="text-danger">{{ $errors->first('kode_alternatif') }}</small>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<label>Username</label>
							<input type="text" name="username" class="form-control" placeholder="Masukkan Username"
								value="{{ old('username') }}">
							<small class="text-danger">{{ $errors->first('username') }}</small>
						</div>
						<div class="form-group col-sm-6">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Masukkan Password"
								value="{{ old('password') }}">
							<small class="text-danger">{{ $errors->first('password') }}</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
