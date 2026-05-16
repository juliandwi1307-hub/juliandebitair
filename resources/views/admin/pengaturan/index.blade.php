@extends('layout/sbadmin')

@section('main')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Pengaturan</h3>
                    </div>
                    <div class="col-sm-6">
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
                            <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
                                <h3 class="card-title mb-0 fs-6">Informasi untuk Pengguna</h3>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <p class="mb-0" id="infoText">
                                            {{ $pengaturan->pengaturan }}
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editInformasiModal">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card -->

                    <!-- Modal Edit Informasi -->
                    <div class="modal fade" id="editInformasiModal" tabindex="-1" aria-labelledby="editInformasiModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('pengaturan.updateInfo', $pengaturan->id) }}" method="POST">
                                {{-- Ganti action dan method sesuai kebutuhan --}}
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editInformasiModalLabel">Edit Informasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="infoEdit">Informasi</label>
                                            <textarea name="pengaturan" id="infoEdit" rows="4" class="form-control">{{ $pengaturan->pengaturan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Card Tarif --}}
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
                                <h3 class="card-title mb-0 fs-6">Tarif Air</h3>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <p class="mb-0">
                                            Rp {{ number_format($tarif->harga, 0, ',', '.') }} / m³
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editTarifModal">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Tarif --}}
                    <div class="modal fade" id="editTarifModal" tabindex="-1" aria-labelledby="editTarifModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('pengaturan.updateTarif', $tarif->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Tarif</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="tarifHarga" class="form-label">Harga per m³</label>
                                            <input type="number" name="harga" id="tarifHarga" class="form-control"
                                                value="{{ $tarif->harga }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
