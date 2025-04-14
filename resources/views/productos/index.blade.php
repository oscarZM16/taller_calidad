@extends('layouts.app')

@section('content')
<form method="GET" action="{{ route('productos.index') }}" class="row g-3 align-items-center mb-4">
    <div class="col-auto">
        <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
    </div>
    <div class="col-auto">
        <select name="estado" class="form-select">
            <option value="">Todos</option>
            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="bajo_stock" class="form-select">
            <option value="">Stock cualquiera</option>
            <option value="1" {{ request('bajo_stock') == '1' ? 'selected' : '' }}>Stock ≤ 5</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-light">🔍 Filtrar</button>
    </div>
</form>
<div class="container">
    <h1 class="mb-4">
        {{ Auth::user()->rol === 'funcionario' ? 'Disponibilidad de Insumos' : 'Administración de Insumos' }}
    </h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <strong>Total Insumos:</strong> {{ $total }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <strong>Activos:</strong> {{ $activos }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <strong>Agotados:</strong> {{ $agotados }}
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @auth
        @if(in_array(Auth::user()->rol, ['administrador', 'supervisor', 'funcionario']))
            <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">+ Nuevo Producto</a>
        @endif
    @endauth

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->stock }}</td>
                <td>{{ $producto->unidad_medida }}</td>
                <td>
                    @if($producto->stock <= 0 || $producto->estado === 'inactivo')
                        <span class="text-danger fw-bold">Agotados</span>
                    @else
                        {{ ucfirst($producto->estado) }}
                    @endif
                </td>
                <td>
                    @if(Auth::user()->rol === 'administrador')
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    @elseif(Auth::user()->rol === 'supervisor')
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                    @elseif(Auth::user()->rol === 'funcionario')
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-info">Ver Detalles</a>
                    @endif

                    <div class="text-muted small mt-1">Último cambio: {{ $producto->updated_at->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection