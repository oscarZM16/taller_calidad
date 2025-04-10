<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->rol === 'funcionario') {
            return redirect()->route('users.index')->with('error', 'Acceso denegado');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function destroy($id)
    {
        if (auth()->user()->rol === 'funcionario') {
            return redirect()->route('users.index')->with('error', 'No tienes permiso para eliminar usuarios.');
        }
    
        User::destroy($id);
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
    
}
