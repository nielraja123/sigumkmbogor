<!-- resources/views/components/umkm-detail.blade.php -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">Detail UMKM : {{ $spot->name }}</div>
        <div class="card-body">
            <p>
                <h4><strong>Nama UMKM :</strong></h4>
                <h5>{{ $spot->name }}</h5>
            </p>
            <p>
                <h4><strong>Deskripsi :</strong></h4>
                <p>{{ $spot->description }}</p>
            </p>
            <p>
                <h4><strong>Kategori :</strong></h4>
                <p>{{ $spot->category }}</p>
            </p>
            <p>
                <h4><strong>Nama Pemilik :</strong></h4>
                <p>{{ $spot->nama_pemilik }}</p>
            </p>
            <p>
                <h4><strong>Nomor Telepon :</strong></h4>
                <p>{{ $spot->nomor_telepon }}</p>
            </p>
            <p>
                <h4><strong>Alamat :</strong></h4>
                <p>{{ $spot->alamat }}</p>
            </p>
            <p>
                <h4><strong>Kecamatan :</strong></h4>
                <p>{{ $spot->kecamatan }}</p>
            </p>
        </div>
    </div>
</div>
