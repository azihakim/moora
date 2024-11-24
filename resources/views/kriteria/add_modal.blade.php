<!-- Modal -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="add_formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_formModalLabel">Form Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kriteria.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" class="form-control"
                            placeholder="Masukkan Kode Kriteria" value="{{ old('kode_kriteria') }}">
                        <small class="text-danger">{{ $errors->first('kode_kriteria') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control"
                            placeholder="Masukkan Nama Kriteria" value="{{ old('nama_kriteria') }}">
                        <small class="text-danger">{{ $errors->first('nama_kriteria') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" name="bobot" step="0.01" class="form-control" placeholder="Masukkan Bobot"
                            value="{{ old('bobot') }}">
                        <small class="text-danger">{{ $errors->first('bobot') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control">
                            <option value="Benefit" {{ old('jenis') === 'Benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="Cost" {{ old('jenis') === 'Cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('jenis') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
