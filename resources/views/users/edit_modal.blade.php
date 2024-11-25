<!-- Modal -->
<div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="edit_formModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="edit_formModalLabel">Form Edit Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST">
				<div class="modal-body">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="name" class="form-control" placeholder="Masukkan Nama" value="{{ old('name') }}">
						<small class="text-danger">{{ $errors->first('name') }}</small>
					</div>
					<div class="form-group">
						<label>Tanggal Masuk</label>
						<input type="date" name="tgl_masuk" class="form-control" value="{{ old('tgl_masuk') }}">
						<small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" class="form-control" placeholder="Masukkan Username"
							value="{{ old('username') }}">
						<small class="text-danger">{{ $errors->first('username') }}</small>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="Masukkan Password"
							value="{{ old('password') }}">
						<small
							class="text-danger">{{ $errors->first('password') ? $errors->first('password') : 'Kosongkan password jika tidak ingin diubah!' }}</small>
					</div>
					<div class="form-group">
						<label>Jabatan</label>
						<select name="role" class="form-control">
							<option value="Pegawai" {{ old('role') === 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
							<option value="HRD" {{ old('role') === 'HRD' ? 'selected' : '' }}>HRD</option>
							<option value="Direktur" {{ old('role') === 'Direktur' ? 'selected' : '' }}>Direktur
							</option>
						</select>
						<small class="text-danger">{{ $errors->first('role') }}</small>
					</div>
					<div class="form-group">
						<label>Kode Alternatif</label>
						<input type="text" name="kode_alternatif" class="form-control" placeholder="Masukkan Kode Alternatif"
							value="{{ old('kode_alternatif') }}">
						<small class="text-danger">{{ $errors->first('kode_alternatif') }}</small>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary">Ubah</button>
				</div>
			</form>
		</div>
	</div>
</div>
