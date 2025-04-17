<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->rol, ['administrador', 'supervisor'])) {
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

    public function bandeja(Request $request)
    {
        $nombre = $request->input('nombre');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = \App\Models\Insumo::query();

        if ($nombre) {
            $query->where('nombre', 'like', "%{$nombre}%");
        }

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        $todos = $query->get();

        $disponibles = $todos->where('estado', 'disponible');
        $prestados = $todos->where('estado', 'prestado');
        $averiados = $todos->where('estado', 'averiado');

        return view('insumos.bandeja', compact('disponibles', 'prestados', 'averiados', 'nombre', 'fechaInicio', 'fechaFin'));
    }
}