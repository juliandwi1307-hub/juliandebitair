@extends('layout/sbadmin')

@section('main')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Ubah Data Admin</h3>
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
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title"> Formulir Ubah Data Admin</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="/admin/{{ $admin->id }}" method="post">
                                @csrf
                                @method('PUT')
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $admin->nama) }}" />
                                        @error('nama')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username"
                                            value="{{ old('username', $admin->username) }}" />
                                        @error('username')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password"
                                            value="{{ old('password', $admin->password) }}" />
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
@endsection
