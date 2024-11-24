<!-- Modal -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="add_formModalLabel"
    aria-hidden="true">
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
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control"
                            placeholder="Masukkan Nama" value="{{ old('name') }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control"
                            placeholder="Masukkan Username" value="{{ old('username') }}">
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Masukkan Password" value="{{ old('password') }}">
                        <small class="text-danger">{{ $errors->first('password') }}</small>
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
                        <input type="text" name="kode_alternatif" class="form-control"
                            placeholder="Masukkan Kode Alternatif" value="{{ old('kode_alternatif') }}">
                        <small class="text-danger">{{ $errors->first('kode_alternatif') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
