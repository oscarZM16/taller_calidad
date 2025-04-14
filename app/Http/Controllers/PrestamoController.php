<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    public function index()
    {
        // Mostrar todos los préstamos del funcionario autenticado
        $prestamos = Prestamo::with('insumo')
            ->where('user_id', Auth::id())
            ->get();

        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        // Mostrar todos los insumos
        $insumos = Insumo::all();

        return view('prestamos.create', compact('insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Validar que no haya préstamos aprobados que se crucen en fechas
        $existeConflicto = Prestamo::where('insumo_id', $request->insumo_id)
            ->where('estado', 'aprobado')
            ->where(function($query) use ($request) {
                $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                      ->orWhere(function($q) use ($request) {
                          $q->where('fecha_inicio', '<=', $request->fecha_inicio)
                            ->where('fecha_fin', '>=', $request->fecha_fin);
                      });
            })->exists();

        if ($existeConflicto) {
            return back()->withErrors(['conflicto' => 'El insumo ya está reservado o prestado en este rango de fechas.']);
        }

        Prestamo::create([
            'user_id' => Auth::id(),
            'insumo_id' => $request->insumo_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'pendiente'
        ]);

        return redirect()->route('prestamos.index')->with('success', 'Solicitud enviada correctamente');
    }

    // SOLO PARA ADMINISTRADORES

    public function adminIndex()
    {
        // Ver todas las solicitudes de todos los usuarios
        $prestamos = Prestamo::with(['usuario', 'insumo'])->orderBy('created_at', 'desc')->get();
        return view('prestamos.admin', compact('prestamos'));
    }

    public function cambiarEstado(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'estado' => 'required|in:aprobado,rechazado,finalizado'
        ]);

        $prestamo->estado = $request->estado;
        $prestamo->save();

        if ($request->estado === 'aprobado') {
            $prestamo->insumo->estado = 'prestado';
            $prestamo->insumo->save();
        }

        if ($request->estado === 'finalizado') {
            $prestamo->insumo->estado = 'disponible';
            $prestamo->insumo->save();
        }

        return back()->with('success', 'Estado actualizado correctamente');
    }
}
