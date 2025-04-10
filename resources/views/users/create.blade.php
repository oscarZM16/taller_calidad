<h1>Crear Usuario</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <input name="name" placeholder="Nombre" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Contraseña" required>

    <select name="rol" required>
        <option value="administrador">Administrador</option>
        <option value="supervisor">Supervisor</option>
        <option value="funcionario">Funcionario</option>
    </select>

    <button type="submit">Crear</button>
</form>
