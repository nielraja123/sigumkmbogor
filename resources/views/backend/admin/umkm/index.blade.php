@extends('layouts.dashboard-volt')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Daftar UMKM yang Belum Dikonfirmasi</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama UMKM</th>
                            <th>Pemilik</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($umkms as $umkm)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $umkm->name }}</td>
                            <td>{{ $umkm->nama_pemilik }}</td>
                            <td>{{ $umkm->alamat }}</td>
                            <td>
                                <form action="{{ route('admin.umkm.confirm', $umkm->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
{{-- @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar UMKM yang Belum Dikonfirmasi</div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama UMKM</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Kecamatan</th>
                                    <th>Koordinat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($umkms as $umkm)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $umkm->name }}</td>
                                        <td>{{ $umkm->description }}</td>
                                        <td>{{ $umkm->category }}</td>
                                        <td>{{ $umkm->nama_pemilik }}</td>
                                        <td>{{ $umkm->nomor_telepon }}</td>
                                        <td>{{ $umkm->alamat }}</td>
                                        <td>{{ $umkm->kecamatan }}</td>
                                        <td>{{ $umkm->coordinates }}</td>
                                        <td>
                                            <form action="{{ route('admin.umkm.confirm', $umkm->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Konfirmasi</button>
                                            </form>
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
@endsection --}}