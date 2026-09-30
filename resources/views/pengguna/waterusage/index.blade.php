@extends('layout/sbpengguna')

@section('main')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Pemakaian Air Saya</h3></div>
                <div class="col-sm-6 text-end">
                    <span class="badge bg-success" id="status-badge">
                        <i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Live
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            {{-- Realtime Cards --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3 id="rt-meter-akhir">{{ Auth::guard('web')->user()->meter_akhir ?? 0 }} <sup style="font-size:1rem">m³</sup></h3>
                            <p>Meteran Sekarang</p>
                        </div>
                        <i class="bi bi-speedometer2 small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3 id="rt-pemakaian">0 <sup style="font-size:1rem">m³</sup></h3>
                            <p>Pemakaian Bulan Ini</p>
                        </div>
                        <i class="bi bi-droplet-fill small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $totalPemakaian }} <sup style="font-size:1rem">m³</sup></h3>
                            <p>Total Pemakaian</p>
                        </div>
                        <i class="bi bi-calendar-month small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" id="valve-box" style="background:#6c757d;color:#fff;">
                        <div class="inner">
                            <h3 id="rt-valve">-</h3>
                            <p>Status Katup</p>
                        </div>
                        <i class="bi bi-toggles small-box-icon"></i>
                    </div>
                </div>
            </div>

            {{-- Riwayat Tagihan --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pemakaian Air</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($tagihans as $i => $t)
                        <div class="list-group-item border-0 border-bottom py-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div class="d-flex align-items-center mb-3 mb-md-0">
                                    <div class="bg-light text-primary rounded-3 d-flex flex-column justify-content-center align-items-center me-3 px-3 py-2 text-center" style="min-width: 80px;">
                                        <span class="fs-6 fw-bold">{{ substr($t->bulan, 0, 3) }}</span>
                                        <span class="small text-muted">{{ $t->tahun }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Tagihan Air</h6>
                                        <div class="d-flex gap-3 text-muted small mt-1">
                                            <span><i class="bi bi-arrow-right-circle text-secondary"></i> Awal: {{ $t->awal }}</span>
                                            <span><i class="bi bi-arrow-left-circle text-secondary"></i> Akhir: {{ $t->akhir }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100 w-md-auto justify-content-md-end gap-4">
                                    <div class="text-md-end">
                                        <span class="d-block text-muted small mb-1">Pemakaian: <strong class="text-primary">{{ $t->jumlah }} m³</strong></span>
                                        <span class="fs-5 fw-bold text-dark">Rp {{ number_format($t->tagihan, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        @if($t->status == 'lunas')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> Lunas</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i> Belum</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">Belum ada riwayat tagihan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
function fetchRealtime() {
    fetch('/pemakaian-air/realtime')
        .then(r => r.json())
        .then(data => {
            document.getElementById('rt-meter-akhir').innerHTML = data.meter_akhir + ' <sup style="font-size:1rem">m³</sup>';
            document.getElementById('rt-pemakaian').innerHTML   = data.pemakaian + ' <sup style="font-size:1rem">m³</sup>';

            const isOpen   = data.water_status == 1;
            const valveBox = document.getElementById('valve-box');
            document.getElementById('rt-valve').textContent = isOpen ? 'OPEN' : 'CLOSED';
            valveBox.style.background = isOpen ? '#198754' : '#dc3545';

            document.getElementById('status-badge').className = 'badge bg-success';
            document.getElementById('status-badge').innerHTML = '<i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Live';
        })
        .catch(() => {
            document.getElementById('status-badge').className = 'badge bg-secondary';
            document.getElementById('status-badge').innerHTML = '<i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Offline';
        });
}

fetchRealtime();
setInterval(fetchRealtime, 3000); // polling setiap 3 detik
</script>
@endsection
