<!-- Modal -->
<div class="modal fade" id="input_form" tabindex="-1" role="dialog" aria-labelledby="input_formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="input_formModalLabel">Form Input Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penilaian.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input hidden name='id_user'>
                    @foreach ($kriteria as $k)
                        <div class="form-group">
                            <label>{{ $k->nama_kriteria }}</label>
                            <select name="penilaian[{{$k->id}}]" class="form-control">
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
