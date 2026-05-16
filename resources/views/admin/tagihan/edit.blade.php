@extends('layout/sbadmin')

@section('main')
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Tagihan</h3>
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
                                <div class="card-title">Formulir Edit Tagihan</div>
                            </div>

                            <form action="{{ route('tagihan.update', $tagihan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">

                                    {{-- Auto Suggest Pengguna --}}
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Cari Pengguna</label>

                                        <input type="text" id="pengguna_search"
                                            class="form-control @error('pengguna_id') is-invalid @enderror"
                                            placeholder="Ketik nama pengguna..." autocomplete="off"
                                            value="{{ $tagihan->pengguna->id }} | {{ $tagihan->pengguna->nama }}">

                                        <input type="hidden" name="pengguna_id" id="pengguna_id"
                                            value="{{ $tagihan->pengguna_id }}">

                                        <div id="pengguna_list" class="list-group position-absolute w-100"
                                            style="z-index: 10;"></div>

                                        @error('pengguna_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Bulan --}}
                                    <div class="mb-3">
                                        <label class="form-label">Bulan</label>
                                        <select class="form-control @error('bulan') is-invalid @enderror" name="bulan"
                                            id="bulan">
                                            <option value="">-- Pilih Bulan --</option>
                                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                                                <option value="{{ $b }}"
                                                    {{ old('bulan', $tagihan->bulan) == $b ? 'selected' : '' }}>
                                                    {{ $b }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bulan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Tahun --}}
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="number" name="tahun" id="tahun"
                                            class="form-control @error('tahun') is-invalid @enderror"
                                            value="{{ old('tahun', $tagihan->tahun) }}">
                                        @error('tahun')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Meter Awal --}}
                                    <div class="mb-3">
                                        <label class="form-label">Meter Awal (m³)</label>
                                        <input type="number" name="awal" id="awal"
                                            class="form-control @error('awal') is-invalid @enderror"
                                            value="{{ old('awal', $tagihan->awal) }}">
                                        @error('awal')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Meter Akhir --}}
                                    <div class="mb-3">
                                        <label class="form-label">Meter Akhir (m³)</label>
                                        <input type="number" name="akhir" id="akhir"
                                            class="form-control @error('akhir') is-invalid @enderror"
                                            value="{{ old('akhir', $tagihan->akhir) }}">
                                        @error('akhir')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Jumlah --}}
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah (m³)</label>
                                        <input type="number" id="jumlah" name="jumlah" class="form-control"
                                            value="{{ old('jumlah', $tagihan->jumlah) }}" readonly>
                                    </div>

                                    {{-- Tarif --}}
                                    <div class="mb-3">
                                        <label class="form-label">Tarif</label>
                                        <input type="text" class="form-control" readonly
                                            value="Rp {{ number_format($tarif->harga, 0, ',', '.') }} / m³">
                                        <input type="hidden" id="tarif" name="tarif" value="{{ $tarif->harga }}">
                                    </div>

                                    {{-- Total --}}
                                    <div class="mb-3">
                                        <label class="form-label">Total Tagihan</label>
                                        <input type="number" id="tagihan" name="tagihan" class="form-control"
                                            value="{{ old('tagihan', $tagihan->tagihan) }}" readonly>
                                    </div>

                                    {{-- Status --}}
                                    <div class="mb-3">
                                        <label class="form-label">Status Pembayaran</label>
                                        <select class="form-control" name="status">
                                            <option value="lunas" {{ $tagihan->status == 'lunas' ? 'selected' : '' }}>
                                                Lunas</option>
                                            <option value="belum lunas"
                                                {{ $tagihan->status == 'belum lunas' ? 'selected' : '' }}>Belum Lunas
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>

    {{-- Hitung Jumlah & Tagihan --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

                tagihan.value = j * parseInt(tarif.value);
            }

            awal.addEventListener('input', hitung);
            akhir.addEventListener('input', hitung);

            hitung();
        });
    </script>

    {{-- Auto Suggest User --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('pengguna_search');
            const list = document.getElementById('pengguna_list');
            const hidden = document.getElementById('pengguna_id');

            const data = @json($penggunas);

            search.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                list.innerHTML = '';

                if (!keyword) {
                    list.style.display = 'none';
                    return;
                }

                const filtered = data.filter(p => p.nama.toLowerCase().includes(keyword));

                filtered.forEach(p => {
                    const item = document.createElement('button');
                    item.className = 'list-group-item list-group-item-action';
                    item.type = 'button';
                    item.textContent = `${p.id} | ${p.nama}`;
                    item.addEventListener('click', () => {

                        search.value = `${p.id} | ${p.nama}`;
                        hidden.value = p.id;
                        list.innerHTML = '';
                        list.style.display = 'none';

                        // Ambil data meter terakhir
                        fetch(`/api/data-terakhir/${p.id}`)
                            .then(res => res.json())
                            .then(d => {
                                document.getElementById('awal').value = d.meter_akhir ||
                                    0;
                                document.getElementById('awal').dispatchEvent(new Event(
                                    'input'));

                                if (d.bulan) {
                                    document.getElementById('bulan').value = d.bulan;
                                }
                                if (d.tahun) {
                                    document.getElementById('tahun').value = d.tahun;
                                }
                            });
                    });
                    list.appendChild(item);
                });

                list.style.display = filtered.length ? 'block' : 'none';
            });

            document.addEventListener('click', e => {
                if (!list.contains(e.target) && e.target !== search) {
                    list.style.display = 'none';
                }
            });
        });
    </script>
@endsection
