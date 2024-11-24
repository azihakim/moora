<!-- Modal -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="add_formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_formModalLabel">Form Tambah Sub Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sub_kriteria.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" readonly>
                        <input hidden name="id_kriteria">
                        <small class="text-danger">{{ $errors->first('id_kriteria') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Sub Kriteria</label>
                        <input type="text" name="nama_sub_kriteria" class="form-control"
                            placeholder="Masukkan Nama Sub Kriteria" value="{{ old('nama_sub_kriteria') }}">
                        <small class="text-danger">{{ $errors->first('nama_sub_kriteria') }}</small>
                    </div>
                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="number" name="nilai" class="form-control" placeholder="Masukkan Nilai"
                            value="{{ old('nilai') }}">
                        <small class="text-danger">{{ $errors->first('nilai') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
