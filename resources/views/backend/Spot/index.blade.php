@extends('layouts.dashboard-volt')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        List UMKM
                        <a href="{{ route('spot.create') }}" class="btn btn-info btn-sm float-end">Tambah UMKM</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <table class="table" id="dataSpot">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Spot</th>
                                    <th>Koordinat</th>
                                    <th>Kecamatan</th>
                                    <th>Kategori</th>
                                    <th>Konfirmasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($spots as $spot)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $spot->name }}</td>
                                        <td>{{ $spot->coordinates }}</td>
                                        <td>{{ $spot->kecamatan }}</td>
                                        <td>{{ $spot->category }}</td>
                                        <td>{{ $spot->confirmed ? 'Ya' : 'Tidak' }}</td>
                                        <td>
                                            <!-- Button actions -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form action="" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Hapus" style="display:none">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            var table = $('#dataSpot').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                ajax: '{{ route('spot.data') }}',
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: true },
                    { data: 'name' },
                    { data: 'coordinates' },
                    { data: 'kecamatan' },
                    { data: 'category' },
<<<<<<< HEAD
                    { data: 'confirmed', render: function(data, type, row) {
                        return data ? 'Ya' : 'Tidak';
                    }},
=======
>>>>>>> 9bda7455f86c490c2847ffb6b88d6ebcb90dea45
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            // Delegasi event handler untuk tombol delete
            $('#dataSpot').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var href = $(this).data('url');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteForm').attr('action', href).submit();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    }
                });
            });
        });
    </script>
@endpush
