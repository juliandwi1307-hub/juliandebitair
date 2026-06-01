@extends('layout/sbadmin')

@section('main')
    <main class="app-main">
        <!-- Content Header -->
        <div class="app-content-header py-3">
            <div class="container-fluid">
                <div class="row mb-2">
                    @if (session('success'))
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="col-12">
                        <h3 class="mb-0">Data Pengguna Sistem</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Selamat Datang Admin di Menu Data Pengguna Sistem</h3>
                            </div>

                            <div class="card-body">
                                <!-- Filter + Tambah Pengguna (1 baris penuh) -->
                                <form action="{{ route('pengguna.index') }}" method="GET" class="mb-3">
                                    <div class="row g-2 align-items-center">
                                        <!-- Kolom: Limit per halaman -->
                                        <div class="col-auto d-flex align-items-center">
                                            <label for="limit" class="form-label me-2 mb-0">Data per halaman:</label>
                                            <select name="limit" id="limit" class="form-select form-select-sm w-auto"
                                                onchange="this.form.submit()">
                                                @foreach ([10, 25, 50, 100] as $limit)
                                                    <option value="{{ $limit }}"
                                                        {{ request('limit', 10) == $limit ? 'selected' : '' }}>
                                                        {{ $limit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Kolom: Search -->
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Cari nama atau username..."
                                                    value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="bi bi-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Kolom: Tombol Tambah -->
                                        <div class="col-auto">
                                            <a href="{{ route('pengguna.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle"></i> Tambah Pengguna
                                            </a>
                                        </div>
                                    </div>
                                </form>


                                <!-- Card Grid Layout -->
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                    @forelse ($pengguna as $index => $pguna)
                                        <div class="col">
                                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                                <div class="card-body p-4 text-center d-flex flex-column">
                                                    <!-- Avatar -->
                                                    <div class="mb-3 mx-auto d-flex justify-content-center align-items-center bg-primary-subtle text-primary rounded-circle" style="width: 70px; height: 70px; font-size: 28px; font-weight: bold;">
                                                        {{ strtoupper(substr($pguna->nama, 0, 1)) }}
                                                    </div>
                                                    
                                                    <!-- Info -->
                                                    <h5 class="fw-bold text-dark mb-1">{{ $pguna->nama }}</h5>
                                                    <p class="text-muted small mb-4">@ {{ $pguna->username }}</p>
                                                    
                                                    <!-- Actions -->
                                                    <div class="d-flex justify-content-center gap-2 mt-auto">
                                                        <a href="{{ url('pengguna/' . $pguna->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                        <form action="{{ url('pengguna/' . $pguna->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="return confirm('Yakin ingin menghapus?')">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-light text-center p-5 border-0 shadow-sm rounded-4">
                                                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                                <p class="mt-3 text-muted mb-0">Data pengguna tidak ditemukan.</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $pengguna->links('pagination::bootstrap-5') }}
                                </div>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Auto-hide alert -->
    <script>
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 4000);
    </script>
@endsection
