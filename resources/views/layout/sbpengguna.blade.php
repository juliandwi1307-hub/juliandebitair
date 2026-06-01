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
    <!-- Custom Premium SaaS Theme -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body { font-family: 'Inter', sans-serif !important; background-color: #f4f6f9 !important; color: #334155; }
        
        .app-sidebar { background-color: #ffffff !important; border-right: none !important; box-shadow: 4px 0 24px rgba(149, 157, 165, 0.05) !important; }
        .sidebar-brand { border-bottom: none !important; padding: 1.5rem !important; }
        .brand-text { font-weight: 700 !important; color: #1e293b !important; letter-spacing: -0.5px; }

        .nav-sidebar .nav-item { margin-bottom: 0.25rem; padding: 0 0.8rem; }
        .nav-sidebar .nav-link { border-radius: 12px !important; color: #64748b !important; padding: 0.6rem 1rem !important; border: none !important; font-weight: 500; transition: all 0.2s; }
        .nav-sidebar .nav-link:hover { background-color: #f8fafc !important; color: #4f46e5 !important; }
        .nav-sidebar .nav-link.active { background-color: #eef2ff !important; color: #4f46e5 !important; font-weight: 600 !important; }
        .nav-sidebar .nav-link i { font-size: 1.2rem; margin-right: 0.5rem; }

        .app-header { background-color: transparent !important; border-bottom: none !important; padding-top: 0.5rem; }

        .card { border: none !important; border-radius: 20px !important; box-shadow: 0 8px 24px rgba(149, 157, 165, 0.08) !important; background-color: #ffffff !important; }
        .card-header { background-color: transparent !important; border-bottom: 1px solid #f1f5f9 !important; padding: 1.25rem 1.5rem !important; }
        .card-title { font-weight: 600 !important; color: #1e293b !important; }

        .badge { font-weight: 500; padding: 0.4em 0.8em; border-radius: 50rem; }
        .btn { border-radius: 50rem !important; font-weight: 500; padding: 0.4rem 1.2rem; }
        .btn-primary { background-color: #4f46e5 !important; border-color: #4f46e5 !important; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3) !important; }
        .btn-primary:hover { background-color: #4338ca !important; }

        h1, h2, h3, h4, h5, h6 { font-weight: 700 !important; letter-spacing: -0.5px; color: #0f172a; }
        
        .small-box { border-radius: 20px !important; border: none !important; box-shadow: 0 8px 24px rgba(149, 157, 165, 0.08) !important; overflow: hidden; }
    </style>
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
        <aside class="app-sidebar bg-white shadow-sm" data-bs-theme="light">
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
                                <i class="nav-icon bi bi-receipt"></i>
                                <p>Info Bayar</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/pemakaian-air') }}"
                                class="nav-link {{ Request::is('pemakaian-air') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-droplet-fill"></i>
                                <p>Pemakaian Air</p>
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
