@extends('layout/sbpengguna')

@section('main')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                </div>
            </div>
        </div>
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Card Utama -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Selamat Datang {{ auth()->user()->no_pengguna }} |
                                    {{ auth()->user()->nama }} di Aplikasi PAMSIMAS</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Info Pembayaran -->
                                    <div class="col-lg-6 mb-3">
                                        <div class="card border-start card-warning h-100">
                                            <div class="card-header py-2 px-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0 fs-6">Info Pembayaran</h5>
                                                    <a href="{{ url('/infobayar') }}"
                                                        class="btn btn-sm btn-light text-dark">
                                                        <i class="bi bi-arrow-right-circle me-1"></i> Lihat
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-semibold">Lunas</span>
                                                    <span class="text-success fw-bold">{{ $jumlahLunas }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-semibold">Belum Lunas</span>
                                                    <span class="text-danger fw-bold">{{ $jumlahBelumLunas }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informasi dari Admin -->
                                    <div class="col-lg-6 mb-3">
                                        <div class="card border-start card-info h-100">
                                            <div class="card-header py-2 px-3">
                                                <h5 class="card-title mb-0 fs-6">Informasi dari Admin</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">
                                                    {{ $informasiAdmin }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Layanan Konsultasi -->
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Layanan Konsultasi / Narahubung</h6>

                                    <!-- Konsultasi Pembayaran/Tagihan -->
                                    <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                                        <i class="bi bi-whatsapp fs-4 me-3"></i>
                                        <div>
                                            <strong>Konsultasi Pembayaran / Tagihan:</strong><br>
                                            Hubungi <strong>Alif Rahmat Yudha Putra</strong> melalui WhatsApp:
                                            <br>
                                            <a href="https://wa.me/6282133085243?text=Halo%20saya%20ingin%20konsultasi%20mengenai%20pembayaran%20atau%20tagihan."
                                                target="_blank" class="btn btn-success btn-sm mt-2">
                                                <i class="bi bi-whatsapp me-1"></i> Klik untuk Chat
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Konsultasi Kerusakan / PDAM -->
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-whatsapp fs-4 me-3"></i>
                                        <div>
                                            <strong>Konsultasi Kerusakan / Layanan PDAM:</strong><br>
                                            Hubungi <strong>Alif Rahmat Yudha Putra</strong> melalui WhatsApp:
                                            <br>
                                            <a href="https://wa.me/6282133085243?text=Halo%20saya%20ingin%20melaporkan%20kerusakan%20atau%20bertanya%20tentang%20layanan%20PDAM."
                                                target="_blank" class="btn btn-info btn-sm mt-2">
                                                <i class="bi bi-whatsapp me-1"></i> Klik untuk Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Card Utama -->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content-->
    </main>
    <!--end::App Main-->
@endsection
