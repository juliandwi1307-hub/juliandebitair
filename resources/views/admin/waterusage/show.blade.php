@extends('layout/sbadmin')

@section('main')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Water Usage - {{ $pengguna->nama }}</h3></div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $tagihans->sum('jumlah') }} m³</h3>
                            <p>Total Pemakaian</p>
                        </div>
                        <i class="bi bi-droplet-fill small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $tagihans->where('status','lunas')->count() }}</h3>
                            <p>Tagihan Lunas</p>
                        </div>
                        <i class="bi bi-check-circle small-box-icon"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $tagihans->where('status','belum lunas')->count() }}</h3>
                            <p>Belum Lunas</p>
                        </div>
                        <i class="bi bi-x-circle small-box-icon"></i>
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
@endsection
