@extends('layouts.index')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Alternatif</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-primary mb-3" id="btn_add">Tambah Alternatif</button>
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
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $a->kode_alternatif }}</td>
                                        <td>{{ $a->nama_alternatif }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn_edit"
                                                data-data='{{ $a }}'>Edit</button>
                                            <button class="btn btn-sm btn-danger btn_delete"
                                                data-id='{{ $a->id }}'>Delete</button>
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

    @include('alternatif.add_modal')
    @include('alternatif.edit_modal')
    @include('alternatif.delete_modal')
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#dataTable').DataTable();
            $('#btn_add').on('click', function() {
                $("#add_form").modal('show')
            })
            $(".btn_edit").on('click', function() {
                const data = $(this).data('data')
                const form = $("#edit_form form")
                $("#edit_form").modal('show')
                form.attr('action', '{{ route('alternatif.index') }}/' + data.id)
                form.find('input[name=kode_alternatif]').val(data.kode_alternatif)
                form.find('input[name=nama_alternatif]').val(data.nama_alternatif)
            })
            $(".btn_delete").on('click', function() {
                const id = $(this).data('id')
                $("#delete_modal").modal('show')
                $("#delete_form").attr('action', '{{ route('alternatif.index') }}/' + id)
            })
        });
    </script>

    @if ($errors->any())
        <script>
            console.log('Validation Errors..')
        </script>
        @if (session()->get('method') === 'store')
            <script>
                $("#add_form").modal('show')
            </script>
        @endif
        @if (session()->get('method') === 'update')
            <script>
                $("#edit_form").modal('show')
                $("#edit_form form").attr('action', '{{ route('alternatif.index') }}/' + '{{ session()->get('id') }}')
            </script>
        @endif
    @endif
@endpush
