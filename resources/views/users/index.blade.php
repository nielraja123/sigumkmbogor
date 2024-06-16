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
                    Kelola Pengguna
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

                    <table class="table" id="dataUser">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Dibuat Pada</th>
                                <th>Diperbarui Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function() {
            var table = $('#dataUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.index') }}',
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                    { 
                        data: 'action', 
                        orderable: false, 
                        searchable: false 
                    }
                ]
            });

            $('#dataUser').on('click', '.toggle-admin', function() {
                var userId = $(this).data('id');
                $.post('{{ url("users") }}/' + userId + '/toggle-admin', {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    table.ajax.reload();
                });
            });
        });
    </script>
@endpush
