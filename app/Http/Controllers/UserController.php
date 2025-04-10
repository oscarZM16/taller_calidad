<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Mostrar el formulario de creación de usuario
    public function create()
    {
        return view('users.create');
    }

    // Guardar un nuevo usuario
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:administrador,supervisor,funcionario',
        ]);

        // Crear el nuevo usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        // Redirigir con mensaje
        return redirect()->route('users.index')->with('success', 'Usuario creado');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Usuario eliminado');
    }
}
