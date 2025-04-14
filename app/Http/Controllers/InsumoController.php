<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends Controller
{
    public function __construct()
    {
        // Solo el administrador puede acceder
        $this->middleware(function ($request, $next) {
            if (Auth::user()->rol !== 'administrador') {
                return redirect()->route('users.index')->with('error', 'Acceso denegado');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $insumos = Insumo::all();
        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|string',
        ]);

        Insumo::create($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo creado correctamente');
    }

    public function edit(Insumo $insumo)
    {
        return view('insumos.edit', compact('insumo'));
    }

    public function update(Request $request, Insumo $insumo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|string',
        ]);

        $insumo->update($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado');
    }
}