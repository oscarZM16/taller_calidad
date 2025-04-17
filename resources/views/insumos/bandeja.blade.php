@extends('layouts.app')

@section('content')
<div class="container">
    {{-- FORMULARIO DE FILTRO --}}
    <form method="GET" action="{{ route('insumos.bandeja') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Nombre del insumo</label>
            <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}" placeholder="Buscar por nombre">
        </div>
        <div class="col-md-3">
            <label class="form-label">Fecha inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Fecha fin</label>
            <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('insumos.bandeja') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <h2 class="mb-4">📦 Bandeja de Insumos</h2>

    {{-- DISPONIBLES --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">En Bodega (Disponibles)</div>
        <div class="card-body">
            @forelse($disponibles as $item)
                <p>🟢 {{ $item->nombre }} - {{ $item->descripcion }}</p>
            @empty
                <p>No hay insumos disponibles.</p>
            @endforelse
        </div>
    </div>

    {{-- PRESTADOS --}}
    <div class="card mb-4">
        <div class="card-header bg-warning">Prestados</div>
        <div class="card-body">
            @forelse($prestados as $item)
                <p>🟡 {{ $item->nombre }} - {{ $item->descripcion }}</p>
            @empty
                <p>No hay insumos prestados.</p>
            @endforelse
        </div>
    </div>

    {{-- AVERIADOS --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">Averiados</div>
        <div class="card-body">
            @forelse($averiados as $item)
                <p>🔴 {{ $item->nombre }} - {{ $item->descripcion }}</p>
            @empty
                <p>No hay insumos averiados.</p>
            @endforelse
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            ⬅ Volver al Panel Principal
        </a>
    </div>
</div>
@endsection
