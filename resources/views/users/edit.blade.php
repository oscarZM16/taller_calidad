@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Editar Usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores en el formulario:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña (dejar en blanco si no desea cambiarla)</label>
            <input name="password" type="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-select" required>
                <option value="administrador" {{ $user->rol === 'administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="supervisor" {{ $user->rol === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="funcionario" {{ $user->rol === 'funcionario' ? 'selected' : '' }}>Funcionario</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
