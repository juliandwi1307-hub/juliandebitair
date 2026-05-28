@extends('layout/sbadmin')

@section('main')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Water Usage - Semua Pengguna</h3></div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pemakaian Air per Pengguna</h3>
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama..." value="{{ request('search') }}">
                        <button class="btn btn-sm btn-primary">Cari</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Total Pemakaian (m³)</th>
                                <th>Jumlah Tagihan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggunas as $p)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $p->nama }}</td>
                                <td><span class="badge bg-primary">{{ $p->tagihans_sum_jumlah ?? 0 }} m³</span></td>
                                <td>{{ $p->tagihans_count }}</td>
                                <td>
                                    <a href="{{ route('waterusage.admin.show', $p->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-droplet-fill"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{{ $penggunas->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</main>
@endsection
