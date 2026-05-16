<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Julian Peler</title>
    <link rel="icon" type="image/png" href="{{ asset('images/tb-logo.jpg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap & AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.css') }}">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .login-logo a {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: #343a40;
        }

        .login-box-msg {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
            text-align: center;
        }

        .input-group-text {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card bg-white">
            <div class="text-center login-logo mb-3">
                <img src="{{ asset('images/tb-logo.jpg') }}" alt="Logo" class="mb-2" style="max-height: 80px;">
                <br>
                <a href="#"><b>Julian</b> Peler</a>
            </div>


            <p class="login-box-msg">Masuk</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" name="username" class="form-control" placeholder="Username"
                            value="{{ old('username') }}" required>
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="{{ asset('templates/dist/js/adminlte.js') }}"></script>
</body>

</html>
