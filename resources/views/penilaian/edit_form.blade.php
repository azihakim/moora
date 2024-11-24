<!-- Modal -->
<div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="edit_formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_formModalLabel">Form Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input hidden name='id_user'>
                    @foreach ($kriteria as $k)
                        <div class="form-group">
                            <label>{{ $k->nama_kriteria }}</label>
                            <select name="penilaian[{{ $k->id }}]" class="form-control">
                                @foreach ($k->sub_kriteria as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->nama_sub_kriteria }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Input</button>
                </div>
            </form>
        </div>
    </div>
</div>
