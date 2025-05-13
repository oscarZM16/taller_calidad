@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📁 Reporte de Préstamos</h2>

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Insumo</th>
                <th>Solicitado por</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Solicitado el</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestamos as $prestamo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $prestamo->insumo->nombre }}</td>
                    <td>{{ $prestamo->user->name }}</td>
                    <td>{{ $prestamo->fecha_inicio }}</td>
                    <td>{{ $prestamo->fecha_fin }}</td>
                    <td>{{ ucfirst($prestamo->estado) }}</td>
                    <td>{{ $prestamo->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay préstamos registrados.</td>
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