<!-- form.blade.php -->
<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="form-group">
        <label for="">Koordinat</label>
        <input type="text" class="form-control @error('coordinate') is-invalid @enderror" name="coordinate" id="coordinate" value="{{ old('coordinate', $spot->coordinate ?? '') }}">
        @error('coordinate')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="">Nama UMKM</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $spot->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="">Deskripsi</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{ old('description', $spot->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="category">Kategori</label>
        <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
            <option value="">Pilih Kategori</option>
            <option value="Makanan" {{ (old('category', $spot->category ?? '') == 'Makanan') ? 'selected' : '' }}>Makanan</option>
            <option value="Pangan" {{ (old('category', $spot->category ?? '') == 'Pangan') ? 'selected' : '' }}>Pangan</option>
            <option value="Gas" {{ (old('category', $spot->category ?? '') == 'Gas') ? 'selected' : '' }}>Gas</option>
            <option value="Kendaraan" {{ (old('category', $spot->category ?? '') == 'Kendaraan') ? 'selected' : '' }}>Kendaraan</option>
            <option value="Kerajinan" {{ (old('category', $spot->category ?? '') == 'Kerajinan') ? 'selected' : '' }}>Kerajinan</option>
            <option value="Fashion" {{ (old('category', $spot->category ?? '') == 'Fashion') ? 'selected' : '' }}>Fashion</option>
            <option value="Kecantikan" {{ (old('category', $spot->category ?? '') == 'Kecantikan') ? 'selected' : '' }}>Kecantikan</option>
            <option value="Kantin Sekolah" {{ (old('category', $spot->category ?? '') == 'Kantin Sekolah') ? 'selected' : '' }}>Kantin Sekolah</option>
            <option value="Kuliner" {{ (old('category', $spot->category ?? '') == 'Kuliner') ? 'selected' : '' }}>Kuliner</option>
            <option value="Otomotif" {{ (old('category', $spot->category ?? '') == 'Otomotif') ? 'selected' : '' }}>Otomotif</option>
            <option value="Pendidikan" {{ (old('category', $spot->category ?? '') == 'Pendidikan') ? 'selected' : '' }}>Pendidikan</option>
            <option value="PKL" {{ (old('category', $spot->category ?? '') == 'PKL') ? 'selected' : '' }}>PKL</option>
            <option value="Teknologi Internet" {{ (old('category', $spot->category ?? '') == 'Teknologi Internet') ? 'selected' : '' }}>Teknologi Internet</option>
            <option value="Rumah/Warung Makan" {{ (old('category', $spot->category ?? '') == 'Rumah/Warung Makan') ? 'selected' : '' }}>Rumah/Warung Makan</option>
            <option value="Agrobisnis" {{ (old('category', $spot->category ?? '') == 'Agrobisnis') ? 'selected' : '' }}>Agrobisnis</option>
            <option value="Minuman" {{ (old('category', $spot->category ?? '') == 'Minuman') ? 'selected' : '' }}>Minuman</option>
            <option value="Jasa" {{ (old('category', $spot->category ?? '') == 'Jasa') ? 'selected' : '' }}>Jasa</option>
            <option value="Kesehatan" {{ (old('category', $spot->category ?? '') == 'Kesehatan') ? 'selected' : '' }}>Kesehatan</option>
            <option value="Warung Sembako" {{ (old('category', $spot->category ?? '') == 'Warung Sembako') ? 'selected' : '' }}>Warung Sembako</option>
            <option value="Lainnya" {{ (old('category', $spot->category ?? '') == 'Lainnya') ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="">Nama Pemilik</label>
        <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik" value="{{ old('nama_pemilik', $spot->nama_pemilik ?? '') }}">
        @error('nama_pemilik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="">Nomor Telepon</label>
        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon', $spot->nomor_telepon ?? '') }}">
        @error('nomor_telepon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="">Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="10">{{ old('alamat', $spot->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group my-3">
        <label for="kecamatan">Kecamatan</label>
        <select name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
            <option value="">Pilih Kecamatan</option>
            <option value="Bogor Selatan" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Bogor Selatan') ? 'selected' : '' }}>Bogor Selatan</option>
            <option value="Bogor Timur" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Bogor Timur') ? 'selected' : '' }}>Bogor Timur</option>
            <option value="Bogor Tengah" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Bogor Tengah') ? 'selected' : '' }}>Bogor Tengah</option>
            <option value="Bogor Barat" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Bogor Barat') ? 'selected' : '' }}>Bogor Barat</option>
            <option value="Bogor Utara" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Bogor Utara') ? 'selected' : '' }}>Bogor Utara</option>
            <option value="Tanah Sareal" {{ (old('kecamatan', $spot->kecamatan ?? '') == 'Tanah Sareal') ? 'selected' : '' }}>Tanah Sareal</option>
        </select>
        @error('kecamatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    </div>
</form>
