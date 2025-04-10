@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">
        {{ Auth::user()->rol === 'funcionario' ? 'Disponibilidad de Insumos' : 'Administración de Insumos' }}
    </h1>

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
        @if(in_array(Auth::user()->rol, ['administrador', 'supervisor']))
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
                <td>{{ ucfirst($producto->estado) }}</td>
                <td>
                    @if(in_array(Auth::user()->rol, ['administrador', 'supervisor']))
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    @else
                        <span class="text-muted">Sin acciones</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection