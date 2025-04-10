<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $routeName = $request->route()->getName();

            if (in_array($routeName, ['productos.create', 'productos.store', 'productos.edit', 'productos.update'])) {
                if (!in_array(Auth::user()->rol, ['administrador', 'supervisor', 'funcionario'])) {
                    abort(403, 'Acceso no autorizado');
                }
            }

            if ($routeName === 'productos.destroy') {
                if (!in_array(Auth::user()->rol, ['administrador', 'supervisor'])) {
                    abort(403, 'Acceso no autorizado');
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // Filtros dinámicos desde el formulario
        $query = Producto::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->bajo_stock == '1') {
            $query->where('stock', '<=', 5);
        }

        $productos = $query->get();

        // Reportes generales
        $total = Producto::count();
        $activos = Producto::where('estado', 'activo')->count();
        $inactivos = Producto::where('estado', 'inactivo')->count();
        $bajoStock = Producto::where('stock', '<=', 5)->count();

        return view('productos.index', compact('productos', 'total', 'activos', 'inactivos', 'bajoStock'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(StoreProductoRequest $request)
    {
        Producto::create($request->validated());
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());

        $fechaCambio = now()->format('d/m/Y H:i');
        return redirect()->route('productos.index')->with('success', 'Producto actualizado el ' . $fechaCambio);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}