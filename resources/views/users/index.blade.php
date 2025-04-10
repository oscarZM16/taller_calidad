@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Listado de Usuarios</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        @if(auth()->user()->rol === 'funcionario')
           
            <a href="{{ route('users.create') }}" class="btn btn-primary me-2">+ Crear Usuario</a>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-light">🛠 Administración de insumos</a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-secondary text-capitalize">{{ $user->rol }}</span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if(auth()->user()->rol !== 'funcionario')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">Editar</a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            @else
                                <span class="text-muted">Sin acciones</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
