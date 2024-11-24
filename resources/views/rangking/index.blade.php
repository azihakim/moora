@extends('layouts.index')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rangking</h1>
        </div>
        <!-- Content Row -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nama Alternatif</th>
                                    <th>Nilai Yi</th>
                                    <th>Ranking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($nilai_yi as $ny)
                                    <tr>
                                        <td>{{ $ny['nama_alternatif'] }}</td>
                                        <td>{{ number_format($ny['yi'], 4) }}</td>
                                        <td>{{ $i++ }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#dataTable').DataTable({
                paging: false, // Disable pagination
                searching: false, // Disable the search field
                info: false, // Disable "Showing 1 to 10 of x entries" message
                ordering: false
            });
        });
    </script>
@endpush
