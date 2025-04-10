@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Insumo</h1>

    <!-- Botón para volver al inicio -->
    <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">🏠 Volver al inicio</a>

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="unidad_medida" class="form-label">Unidad de Medida</label>
            <select name="unidad_medida" class="form-control" required>
                <option value="">-- Selecciona una unidad --</option>
                <option value="unidades" {{ old('unidad_medida') == 'unidades' ? 'selected' : '' }}>Unidades</option>
                <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramos</option>
                <option value="litros" {{ old('unidad_medida') == 'litros' ? 'selected' : '' }}>Litros</option>
                <option value="metros" {{ old('unidad_medida') == 'metros' ? 'selected' : '' }}>Metros</option>
                <option value="cajas" {{ old('unidad_medida') == 'cajas' ? 'selected' : '' }}>Cajas</option>
            </select>
            @error('unidad_medida') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection