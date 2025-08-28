<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo;
use App\Models\Prestamo;

class ReporteController extends Controller
{
    public function reporteInsumos()
    {
        
        $insumos = Insumo::all();
        return view('reportes.insumos', compact('insumos'));
    }

    public function reportePrestamos()
    {
        $prestamos = Prestamo::with('insumo', 'user')->get();
        return view('reportes.prestamos', compact('prestamos'));
    }

    public function reporteDisponibles()
    {
        $insumos = Insumo::where('estado', 'disponible')->get();
        return view('reportes.disponibles', compact('insumos'));
    }
}
