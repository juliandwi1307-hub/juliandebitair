@extends('layout/sbadmin')

@section('main')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tambah Tagihan</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">Formulir Tambah Tagihan</div>
                            </div>

                            <form action="/tagihan" method="POST">
                                @csrf
                                <div class="card-body">

                                    {{-- Search Pengguna --}}
                                    <div class="mb-3 position-relative">
                                        <label for="pengguna_search" class="form-label">Cari Pengguna</label>
                                        <input type="text" id="pengguna_search"
                                            class="form-control @error('pengguna_id') is-invalid @enderror"
                                            placeholder="Ketik nama pengguna..." autocomplete="off">

                                        <input type="hidden" name="pengguna_id" id="pengguna_id">

                                        <div id="pengguna_list" class="list-group position-absolute w-100"
                                            style="z-index:10;"></div>

                                        @error('pengguna_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Bulan --}}
                                    <div class="mb-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <select class="form-control" id="bulan" name="bulan">
                                            <option value="">-- Pilih Bulan --</option>
                                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                                                <option value="{{ $b }}">{{ $b }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tahun --}}
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="number" id="tahun" name="tahun" class="form-control"
                                            value="{{ date('Y') }}">
                                    </div>

                                    {{-- Meter Awal --}}
                                    <div class="mb-3">
                                        <label for="awal" class="form-label">Meter Awal (m³)</label>
                                        <input type="number" id="awal" name="awal" class="form-control">
                                    </div>

                                    {{-- Meter Akhir --}}
                                    <div class="mb-3">
                                        <label for="akhir" class="form-label">Meter Akhir (m³)</label>
                                        <input type="number" id="akhir" name="akhir" class="form-control">
                                    </div>

                                    {{-- Jumlah Pemakaian --}}
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah (m³)</label>
                                        <input type="number" id="jumlah" name="jumlah" class="form-control" readonly>
                                    </div>

                                    {{-- Tarif --}}
                                    <div class="mb-3">
                                        <label class="form-label">Tarif</label>
                                        <input type="text" class="form-control"
                                            value="Rp {{ number_format($tarif->harga) }} / m³" readonly>
                                        <input type="hidden" id="tarif" name="tarif" value="{{ $tarif->harga }}">
                                    </div>

                                    {{-- Total Tagihan --}}
                                    <div class="mb-3">
                                        <label for="tagihan" class="form-label">Total Tagihan</label>
                                        <input type="number" id="tagihan" name="tagihan" class="form-control" readonly>
                                    </div>

                                </div>

                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- SCRIPT: Auto Suggest + Hitung Manual --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //------------------------------
            // Auto Suggest Pengguna
            //------------------------------
            const penggunaSearch = document.getElementById('pengguna_search');
            const penggunaList = document.getElementById('pengguna_list');
            const hiddenInput = document.getElementById('pengguna_id');
            const penggunaData = @json($penggunas);

            penggunaSearch.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                penggunaList.innerHTML = '';

                if (!keyword) {
                    penggunaList.style.display = 'none';
                    return;
                }

                const result = penggunaData.filter(p => p.nama.toLowerCase().includes(keyword));

                if (result.length > 0) {
                    result.forEach(p => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = `${p.id} | ${p.nama}`;

                        item.addEventListener('click', function() {
                            penggunaSearch.value = `${p.id} | ${p.nama}`;
                            hiddenInput.value = p.id;

                            penggunaList.innerHTML = '';
                            penggunaList.style.display = 'none';

                            // Ambil meter terakhir
                            fetch(`/api/data-terakhir/${p.id}`)
                                .then(res => res.json())
                                .then(data => {
                                    document.getElementById('awal').value = data
                                        .meter_akhir || 0;
                                    hitung();
                                });
                        });

                        penggunaList.appendChild(item);
                    });

                    penggunaList.style.display = 'block';
                } else {
                    penggunaList.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e) {
                if (!penggunaList.contains(e.target) && e.target !== penggunaSearch) {
                    penggunaList.innerHTML = '';
                    penggunaList.style.display = 'none';
                }
            });

            //------------------------------
            // Perhitungan Manual (TANPA abonemen)
            //------------------------------
            const awal = document.getElementById('awal');
            const akhir = document.getElementById('akhir');
            const jumlah = document.getElementById('jumlah');
            const tarif = document.getElementById('tarif');
            const tagihan = document.getElementById('tagihan');

            function hitung() {
                const a = parseInt(awal.value) || 0;
                const b = parseInt(akhir.value) || 0;

                const j = Math.max(b - a, 0);
                jumlah.value = j;

                const t = parseInt(tarif.value) || 0;

                tagihan.value = j * t; // TANPA abonemen
            }

            akhir.addEventListener('input', hitung);
        });
    </script>
@endsection
