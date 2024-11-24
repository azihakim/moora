@extends('layouts.index')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penilaian</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Alternatif</th>
                                    <th>Nama Alternatif</th>
                                    <th style="width:128px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($users as $u)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $u->kode_alternatif }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>
                                            @if ($u->penilaian()->count() > 0)
                                                <button class="btn btn-sm btn-warning btn_edit"
                                                    data-data='{{ $u }}'
                                                    data-penilaian='{{ $u->penilaian }}'>Edit</button>
                                            @else
                                                <button class="btn btn-sm btn-success btn_input"
                                                    data-data='{{ $u }}'>Input</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('penilaian.input_form')
    @include('penilaian.edit_form')
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#dataTable').DataTable();
            $('.btn_input').on('click', function() {
                const data = $(this).data('data')
                $('input[name=id_user]').val(data.id)
                $("#input_form").modal('show')
            })
            $(".btn_edit").on('click', function() {
                const data = $(this).data('data')
                const penilaian = $(this).data('penilaian')
                $('input[name=id_user]').val(data.id)
                penilaian.forEach((p) => {
                    $('select[name="penilaian[' + p.id_kriteria + ']"]').val(p.id_sub_kriteria)
                })
                $("#edit_form form").attr('action', '{{ route('penilaian.index') }}/' + data.id)
                $("#edit_form").modal('show')
            })
        });
    </script>

    @if ($errors->any())
        <script>
            console.log('Validation Errors..')
        </script>
    @endif
@endpush
