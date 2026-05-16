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


                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th style="width: 50px;">No.</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th style="width: 120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pengguna as $index => $pguna)
                                                <tr>
                                                    <td class="text-center">{{ $pengguna->firstItem() + $index }}</td>
                                                    <td>{{ $pguna->nama }}</td>
                                                    <td>{{ $pguna->username }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ url('pengguna/' . $pguna->id) }}"
                                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form action="{{ url('pengguna/' . $pguna->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                                <i class="bi bi-eraser"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Data pengguna tidak ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-end mt-3">
                                        {{ $pengguna->links('pagination::bootstrap-5') }}
                                    </div>
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
