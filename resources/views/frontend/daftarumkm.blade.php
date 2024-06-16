@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar UMKM</span>
                    <select id="categoryFilter" class="form-select" style="width: 200px;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>

                    <select id="kecamatanFilter" class="form-select" style="width: 200px; display: inline-block;">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan }}">{{ $kecamatan }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="card-body">
                    <table class="table" id="dataSpot">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Spot</th>
                                <th>Koordinat</th>
                                <th>Kategori</th>
                                <th>Kecamatan</th>
                                {{--  --}}
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
{{--  --}}
<script src="{{ asset('volt/html&css/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('volt/html&css/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Vendor JS -->
<script src="{{ asset('volt/html&css/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

<!-- Slider -->
<script src="{{ asset('volt/html&css/vendor/nouislider/dist/nouislider.min.js') }}"></script>

<!-- Smooth scroll -->
<script src="{{ asset('volt/html&css/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>

<!-- Charts -->


<!-- Datepicker -->
<script src="{{ asset('volt/html&css/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- Sweet Alerts 2 -->
<script src="{{ asset('volt/html&css/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker -->
<script src="{{ asset('volt/html&css/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- Notyf -->
<script src="{{ asset('volt/html&css/vendor/notyf/notyf.min.js') }}"></script>

<!-- Simplebar -->
<script src="{{ asset('volt/html&css/vendor/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500,0).slideUp(500,function(){
            $(this).remove()
        })
    }, 3000);
</script>
{{--  --}}

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>

$(document).ready(function() {
        var table = $('#dataSpot').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('spot.data') }}',
                data: function(d) {
                    d.category = $('#categoryFilter').val();
                    d.kecamatan = $('#kecamatanFilter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name' },
                { data: 'coordinates' },
                { data: 'category' },
                { data: 'kecamatan' },
                // 
                { 
                    data: null, 
                    render: function (data, type, row) {
                        return '<a href="{{ url('/detail-spot/') }}/'+data.slug+'" class="btn btn-info">Detail</a>';
                    }
                }
            ]
        });

        $('#categoryFilter').change(function() {
            table.draw();
        });

        $('#kecamatanFilter').change(function() {
            table.draw();
        });
    });
</script>
@endpush