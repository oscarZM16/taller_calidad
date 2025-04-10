<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            min-height: 100vh;
        }
        .card-login {
            background-color: #2e2e2e;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">InventarioApp</a>

        @if (auth()->check())
            <div class="d-flex align-items-center ms-auto">
                <span class="text-white me-3">Hola, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            </div>
        @endif
    </div>
</nav>

<div class="container mt-4 d-flex justify-content-center">
    <div class="col-md-6">
        @yield('content')
    </div>
</div>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Revisa el formulario',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
