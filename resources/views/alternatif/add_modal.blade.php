<!-- Modal -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="add_formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_formModalLabel">Form Tambah Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('alternatif.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Kode Alternatif</label>
                        <input type="text" name="kode_alternatif" class="form-control"
                            placeholder="Masukkan Kode Alternatif" value="{{ old('kode_alternatif') }}">
                        <small class="text-danger">{{ $errors->first('kode_alternatif') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="form-control"
                            placeholder="Masukkan Nama Alternatif" value="{{ old('nama_alternatif') }}">
                        <small class="text-danger">{{ $errors->first('nama_alternatif') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
