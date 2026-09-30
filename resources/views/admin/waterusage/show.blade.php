@extends('layout/sbadmin')

@section('main')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Water Usage - {{ $pengguna->nama }}</h3></div>
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
                            <h3 id="rt-meter-akhir">{{ $pengguna->meter_akhir ?? 0 }} <sup style="font-size:1rem">m³</sup></h3>
                            <p>Meteran Sekarang</p>
                        </div>
                        <i class="bi bi-speedometer2 small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3 id="rt-pemakaian">{{ max(0, ($pengguna->meter_akhir ?? 0) - ($pengguna->meter_awal ?? 0)) }} <sup style="font-size:1rem">m³</sup></h3>
                            <p>Pemakaian Bulan Ini</p>
                        </div>
                        <i class="bi bi-droplet-fill small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $tagihans->sum('jumlah') }} m³</h3>
                            <p>Total Pemakaian</p>
                        </div>
                        <i class="bi bi-calendar-month small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" id="valve-box" style="background:{{ $pengguna->water_status ? '#198754' : '#dc3545' }};color:#fff;">
                        <div class="inner">
                            <h3 id="rt-valve">{{ $pengguna->water_status ? 'OPEN' : 'CLOSED' }}</h3>
                            <p>Status Katup</p>
                        </div>
                        <i class="bi bi-toggles small-box-icon"></i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Riwayat Pemakaian Air</h3>
                    <a href="{{ route('waterusage.admin.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Awal (m³)</th>
                                <th>Akhir (m³)</th>
                                <th>Pemakaian (m³)</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihans as $i => $t)
                            <tr class="text-center">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $t->bulan }}</td>
                                <td>{{ $t->tahun }}</td>
                                <td>{{ $t->awal }}</td>
                                <td>{{ $t->akhir }}</td>
                                <td><strong class="text-primary">{{ $t->jumlah }}</strong></td>
                                <td>Rp {{ number_format($t->tagihan, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $t->status == 'lunas' ? 'success' : 'danger' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center">Belum ada data pemakaian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function fetchRealtime() {
    fetch('/waterusage/{{ $pengguna->id }}/realtime')
        .then(r => r.json())
        .then(data => {
            document.getElementById('rt-meter-akhir').innerHTML = data.meter_akhir + ' <sup style="font-size:1rem">m³</sup>';
            document.getElementById('rt-pemakaian').innerHTML   = data.pemakaian   + ' <sup style="font-size:1rem">m³</sup>';

            const isOpen   = data.water_status == 1;
            document.getElementById('rt-valve').textContent     = isOpen ? 'OPEN' : 'CLOSED';
            document.getElementById('valve-box').style.background = isOpen ? '#198754' : '#dc3545';

            document.getElementById('status-badge').className   = 'badge bg-success';
            document.getElementById('status-badge').innerHTML   = '<i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Live';
        })
        .catch(() => {
            document.getElementById('status-badge').className = 'badge bg-secondary';
            document.getElementById('status-badge').innerHTML = '<i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Offline';
        });
}

fetchRealtime();
setInterval(fetchRealtime, 3000);
</script>
@endsection
