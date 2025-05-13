<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            background: linear-gradient(to bottom,rgb(255, 255, 255),rgb(255, 255, 255), #caf0f8);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            font-family: sans-serif;
        }

        .wave-top, .wave-bottom {
            position: absolute;
            width: 100%;
            height: auto;
            left: 0;
            z-index: 0;
        }

        .wave-top {
            top: 0;
        }

        .wave-bottom {
            bottom: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding-bottom: 230px;
        }

        .bg-overlay {
            background-color: rgb(255, 255, 255);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        @media (min-width: 992px) {
            .bg-overlay {
                max-width: 960px;
                margin: auto;
            }
        }
    </style>
</head>

<body>
    <svg class="wave-top" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="#caf0f8" fill-opacity="1"
            d="M0,0L40,10.7C80,21,160,43,240,53.3C320,64,400,64,480,74.7C560,85,640,107,720,128C800,149,880,171,960,160C1040,149,1120,107,1200,90.7C1280,75,1360,85,1400,90.7L1440,96L1440,0L0,0Z">
        </path>
    </svg>

    <div class="content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
            <div class="container-fluid">
                @if (auth()->check())
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <span class="text-white fw-semibold">Bienvenido, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light ms-3">Cerrar sesión</button>
                        </form>
                    </div>
                @endif
            </div>
        </nav>

        <div class="container bg-overlay">
            @yield('content')
        </div>
    </div>

    <svg class="wave-bottom" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="#caf0f8" fill-opacity="1"
            d="M0,224L40,218.7C80,213,160,203,240,186.7C320,171,400,149,480,144C560,139,640,149,720,165.3C800,181,880,203,960,186.7C1040,171,1120,117,1200,90.7C1280,64,1360,64,1400,64L1440,64L1440,320L0,320Z">
        </path>
    </svg>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
