@extends('layout/sbadmin')

@section('main')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <h3 class="mb-0">Tagihan</h3>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Selamat Datang Admin di Menu Tagihan</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tagihan.index') }}" method="GET" class="mb-3">
                                    <div class="row g-2 align-items-center">
                                        <!-- Kiri: Limit per halaman -->
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

                                        <!-- Tengah: Search -->
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Cari nama atau no. pengguna..."
                                                    value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Kanan: Tombol Aksi -->
                                        <div class="col-auto d-flex gap-2">
                                            <a href="{{ route('tagihan.create') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle"></i> Tambah Tagihan
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Awal (m&sup3;)</th>
                                                <th>Akhir (m&sup3;)</th>
                                                <th>Jumlah (m&sup3;)</th>
                                                <th>Tarif per meter</th>
                                                <th>Tagihan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($tagihans as $tagihan)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration + ($tagihans->currentPage() - 1) * $tagihans->perPage() }}
                                                    </td>
                                                    <td class="text-start">{{ $tagihan->pengguna->nama }}</td>
                                                    <td>{{ $tagihan->bulan }}</td>
                                                    <td>{{ $tagihan->tahun }}</td>
                                                    <td class=>{{ $tagihan->awal }}</td>
                                                    <td class=>{{ $tagihan->akhir }}</td>
                                                    <td class=>{{ $tagihan->jumlah }}</td>
                                                    <td class=>{{ number_format($tagihan->tarif, 0, ',', '.') }}
                                                    </td>
                                                    <td class=>
                                                        {{ number_format($tagihan->tagihan, 0, ',', '.') }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $tagihan->status == 'lunas' ? 'success' : 'danger' }}">
                                                            {{ ucfirst($tagihan->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="/tagihan/{{ $tagihan->id }}"
                                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form action="{{ url('tagihan/' . $tagihan->id) }}" method="POST"
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
                                                    <td colspan="13" class="text-center">Data tagihan belum tersedia.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-end mt-3">
                                        {{ $tagihans->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
@endsection
