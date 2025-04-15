@extends('layouts.app')

@section('content')
<style>
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        background: #1e1e2f;
        padding: 20px;
        border-right: 2px solid #00f2ff;
        transform: translateX(-260px);
        transition: transform 0.3s ease;
        z-index: 1000;
        color: white;
    }

    #sidebar.active {
        transform: translateX(0);
    }

    #sidebarToggle {
        position: fixed;
        top: 70px;
        left: 20px;
        z-index: 1100;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: none;
        background-color: #343a40;
        color: white;
        font-size: 24px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background 0.3s ease;
    }

    #sidebarToggle:hover {
        background-color: #495057;
    }

    #mainContent {
        margin-left: 0;
        transition: margin-left 0.3s ease;
    }

    #mainContent.active {
        margin-left: 260px;
    }

    .sidebar-section h6 {
        margin-top: 1.2rem;
        font-weight: bold;
        color: #00f2ff;
    }

    .sidebar-section a {
        display: block;
        margin-bottom: 10px;
        text-decoration: none;
        color: #ddd;
    }

    .sidebar-section a:hover {
        color: #00f2ff;
    }

    .sidebar-section a.disabled {
        pointer-events: none;
        color: #6c757d;
    }

    .text-neon {
        color: #00f2ff;
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 0.5px;
    }
</style>

<button id="sidebarToggle">
    <span>&#9776;</span>
</button>

<div id="sidebar">
    <div class="sidebar-section">
        <h6>👥 Gestión de Usuarios</h6>
        @if(in_array(auth()->user()->rol, ['administrador', 'supervisor']))
            <a href="{{ route('users.create') }}">👤 Crear Usuario</a>
            <a href="#" onclick="toggleUsuarios()">👥 Mostrar/Ocultar Usuarios</a>
        @else
            <a class="disabled">🔒 Crear Usuario</a>
        @endif
    </div>

    <div class="sidebar-section">
        <h6>💼 Gestión de Insumos</h6>
        @if(in_array(auth()->user()->rol, ['administrador', 'supervisor']))
            <a href="{{ url('/insumos/create') }}">🧾 Crear Insumo</a>
        @else
            <a class="disabled">🔒 Crear Insumo</a>
        @endif
        <a href="{{ route('insumos.bandeja') }}">🖥️ Bandeja de Insumos</a>
        <a href="{{ url('/bandeja') }}">📦 Bandeja Completa</a>
    </div>

    <div class="sidebar-section">
        <h6>📄 Gestión de Préstamos</h6>
        <a href="{{ url('/prestamos/create') }}">➕ Crear Préstamo</a>
        <a href="{{ url('/prestamos') }}">💻 Solicitudes</a>
        @if(in_array(auth()->user()->rol, ['administrador', 'supervisor']))
            <a href="{{ url('/admin/prestamos') }}">🗂️ Aprobación</a>
        @else
            <a class="disabled">🔒 Aprobación</a>
        @endif
    </div>
</div>

<div id="mainContent">
    <div class="text-center mb-4">
        <h1 class="text-neon" style="font-size: 2.2rem;">🧠 InventarioApp</h1>
        <h4 class="text-muted">📊 Panel de Administración</h4>
    </div>
    <hr class="mb-4">

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

    <div id="tablaUsuarios" style="display: none;">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellidos</th> 
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
                             <td>{{ $user->apellidos ?? '-' }}</td> 
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
                            <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('mainContent').classList.toggle('active');
    });

    function toggleUsuarios() {
        var tabla = document.getElementById("tablaUsuarios");
        tabla.style.display = tabla.style.display === "none" ? "block" : "none";
    }
</script>
@endsection
