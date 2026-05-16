<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Banyu Julian</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.css') }}" />

    <!-- OverlayScrollbars -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print"
        onload="this.media='all'" />
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

    <div class="app-wrapper">

        <!-- HEADER -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- SIDEBAR -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="#" class="brand-link">
                    <img src="{{ asset('template/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">Julian Peler</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard-pengguna') }}"
                                class="nav-link {{ Request::is('dashboard-pengguna') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-palette"></i>
                                <p>Dashboard Pengguna</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/infobayar') }}"
                                class="nav-link {{ Request::is('infobayar') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Info Bayar </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link {{ Request::is('keluar') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-box-arrow-left"></i>
                                    <p>Keluar</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        @yield('main')

        <!-- FOOTER -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Admin Panel</div>
            <strong>&copy; 2025 Banyu Julian.</strong> All rights reserved.
        </footer>
    </div>

    <!-- SCRIPTS -->

    <!-- OverlayScrollbars -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js">
    </script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('template/dist/js/adminlte.js') }}"></script>

    <script>
        // Aktifkan scrollbar custom
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-wrapper');
            if (sidebar && OverlayScrollbarsGlobal?.OverlayScrollbars) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebar, {
                    scrollbars: {
                        autoHide: 'leave',
                    },
                });
            }
        });
    </script>

</body>

</html>
