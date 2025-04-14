@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Insumo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('insumos.update', $insumo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $insumo->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $insumo->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $insumo->cantidad }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="disponible" {{ $insumo->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="prestado" {{ $insumo->estado == 'prestado' ? 'selected' : '' }}>Prestado</option>
                <option value="averiado" {{ $insumo->estado == 'averiado' ? 'selected' : '' }}>Averiado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection