@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="mb-4 text-center">Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-envelope fs-5 text-muted"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0" placeholder="usuario@correo.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock fs-5 text-muted"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Ingresar</button>
            </form>
        </div>
    </div>
@endsection