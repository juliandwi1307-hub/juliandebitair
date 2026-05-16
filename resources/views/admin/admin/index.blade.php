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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <h3 class="mb-0">Data Admin</h3>
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
                                <h3 class="card-title">Selamat Datang Admin di Menu Admin</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="{{ route('admin.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Tambah Admin
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle text-center">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th style="width: 50px;">No.</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th style="width: 120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($admin as $index => $adm)
                                                <tr>
                                                    <td>{{ $admin->firstItem() + $index }}</td>
                                                    <td>{{ $adm->nama }}</td>
                                                    <td>{{ $adm->username }}</td>
                                                    <td>{{ $adm->password }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/' . $adm->id) }}"
                                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <form action="{{ url('admin/' . $adm->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                                <i class="bi bi-eraser"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">Data Admin tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-end mt-3">
                                        {{ $admin->links('pagination::bootstrap-5') }}
                                    </div>
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
    <script>
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 4000); // 4 detik
    </script>
@endsection
