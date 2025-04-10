<h1>Lista de Usuarios</h1>
<a href="{{ route('users.create') }}">Crear nuevo usuario</a>

<ul>
@foreach($users as $user)
    <li>{{ $user->name }} - {{ $user->rol }}
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </li>
@endforeach
</ul>
