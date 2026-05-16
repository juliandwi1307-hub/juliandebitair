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
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
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
                            <div class="card-header">
                                <h3 class="card-title">Selamat Datang Admin di Aplikasi Banyu Julian</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box text-bg-primary">
                                            <div class="inner">
                                                <h3>{{ $jumlahPengguna }}</h3>
                                                <p>Pengguna</p>
                                            </div>
                                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                                </path>
                                            </svg>
                                            <a href="/pengguna"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Info Lebih Lanjut <i class="bi bi-link-45deg"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box text-bg-danger">
                                            <div class="inner">
                                                <h3>{{ $jumlahTagihan }}</h3>
                                                <p>Tagihan Belum Lunas</p>
                                            </div>
                                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path
                                                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                                </path>
                                            </svg>
                                            <a href="/tagihan"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Info Lebih Lanjut <i class="bi bi-link-45deg"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
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
