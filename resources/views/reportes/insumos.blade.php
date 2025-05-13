@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📦 Reporte de Insumos</h2>

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Cantidad</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($insumos as $insumo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $insumo->nombre }}</td>
                    <td>{{ $insumo->descripcion }}</td>
                    <td>{{ ucfirst($insumo->estado) }}</td>
                    <td>{{ $insumo->cantidad }}</td>
                    <td>{{ $insumo->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay insumos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="text-center mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver al Panel Principal
        </a>
    </div>
</div>
@endsection