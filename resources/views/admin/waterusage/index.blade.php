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
                    <div class="list-group list-group-flush border-0">
                        @forelse($penggunas as $p)
                        <div class="list-group-item border-0 border-bottom py-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="d-flex align-items-center w-100 mb-2 mb-md-0">
                                <div class="bg-primary-subtle text-primary rounded-circle d-flex justify-content-center align-items-center me-3 flex-shrink-0" style="width: 48px; height: 48px; font-weight: bold; font-size: 1.2rem;">
                                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $p->nama }}</h6>
                                    <small class="text-muted"><i class="bi bi-receipt"></i> {{ $p->tagihans_count }} Tagihan tercatat</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100 justify-content-md-end gap-4">
                                <div class="text-md-end">
                                    <span class="d-block text-muted small">Total Pemakaian</span>
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $p->tagihans_sum_jumlah ?? 0 }} m³</span>
                                </div>
                                <a href="{{ route('waterusage.admin.show', $p->id) }}" class="btn btn-outline-info rounded-pill px-3 text-nowrap">
                                    Detail <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-5">
                            <i class="bi bi-droplet text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">Belum ada data pemakaian.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer">{{ $penggunas->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</main>
@endsection
