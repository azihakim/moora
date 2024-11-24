@extends('layouts.index')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sub Kriteria</h1>
        </div>
        <!-- Content Row -->
        @foreach ($kriteria as $k)
            <div class="row mb-4">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display:flex; justify-content:space-between; align-items:center">
                                <div class="card-title">{{ $k->nama_kriteria }}</div>
                                <button class="btn btn-primary btn_add" data-data="{{ $k }}">Tambah Sub
                                    Kriteria</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Nama Sub Kriteria</th>
                                        <th>Nilai</th>
                                        <th style="width:128px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($k->sub_kriteria as $sk)
                                        <tr>
                                            <td>{{ $sk->nama_sub_kriteria }}</td>
                                            <td>{{ $sk->nilai }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn_edit"
                                                    data-data='{{ $sk }}'>Edit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('sub_kriteria.add_modal')
    @include('sub_kriteria.edit_modal')
    {{-- @include('sub_kriteria.delete_modal') --}}
@endsection

@push('scripts')
    <script>
        $(function() {
            // $('#dataTable').DataTable();
            $('.btn_add').on('click', function() {
                const data = $(this).data('data')
                $("#add_form form").find('input[name=nama_kriteria]').val(data.nama_kriteria)
                $("#add_form form").find('input[name=id_kriteria]').val(data.id)
                $("#add_form").modal('show')
            })
            $(".btn_edit").on('click', function() {
                const data = $(this).data('data')
                const form = $("#edit_form form")
                $("#edit_form").modal('show')
                form.attr('action', '{{ route('sub_kriteria.index') }}/' + data.id)
                console.log(data)
                form.find('input[name=nama_kriteria]').val(data.kriteria.nama_kriteria)
                form.find('input[name=id_kriteria]').val(data.id_kriteria)
                form.find('input[name=nama_sub_kriteria]').val(data.nama_sub_kriteria)
                form.find('input[name=nilai]').val(data.nilai)
            })
            $(".btn_delete").on('click', function() {
                const id = $(this).data('id')
                $("#delete_modal").modal('show')
                $("#delete_form").attr('action', '{{ route('sub_kriteria.index') }}/' + id)
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
                $("#edit_form form").attr('action', '{{ route('sub_kriteria.index') }}/' + '{{ session()->get('id') }}')
            </script>
        @endif
    @endif
@endpush
