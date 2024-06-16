<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Geografi - Pemetaan UMKM kota Bogor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        @yield('css')
</head>

<style>
    .navbar {
        background: rgb(26, 7, 8);
        background: linear-gradient(0deg, rgb(32, 41, 56) 0%, rgb(32, 41, 56) 100%);
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
                            {{--  --}}
                            @if (session('error'))
                            <script>
                                window.onload = function() {
                                    alert("{{ session('error') }}");
                                };
                            </script>
                        @endif
                {{--  --}}
            <a class="navbar-brand" href="#" style="font-weight: bold; color: white;">SIG UMKM Kota Bogor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/" style="font-weight: bold; color: white;">Peta UMKM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/choroplethhome" style="font-weight: bold; color: white;">Klasifikasi Kecamatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/daftarumkm" style="font-weight: bold; color: white;">Daftar UMKM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/choropleth" style="font-weight: bold; color: white;">Dashboard</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li> --}}
                </ul>
                <ul class="navbar-nav">
                    @if(Auth::check())
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="media d-flex align-items-center">
                                    <div class="">
                                        <span style="font-weight: bold; color: white;">Username : {{ auth()->user()->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <span class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                                <div role="separator" class="dropdown-divider my-1"></div>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                   Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </s>
                        </li>
                        {{-- <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="media d-flex align-items-center">
                                    <div class="">
                                        <span style="font-weight: bold; color: white;">Username : {{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                                <div role="separator" class="dropdown-divider my-1"></div>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                   Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li> --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('login') }}" style="font-weight: bold; color: white;">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    
    @stack('javascript')
</body>
<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
    <div class="row">
        <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
            <p class="mb-0 text-center text-lg-start">© 2024-<span class="current-year"></span> <a
                    class="text-primary fw-normal" href="https://themesberg.com"
                    target="_blank">Andre Nathaniel Adipraja</a></p>
        </div>
        <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
            <!-- List -->
            <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://www.linkedin.com/in/drenathaniel/">Linkedn</a>
                </li>
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://github.com/nielraja123">Github</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
</html>