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
        // Protege las rutas: solo admins y supervisores pueden crear, editar, eliminar
        $this->middleware(function ($request, $next) {
            if (in_array($request->route()->getName(), ['productos.create', 'productos.store', 'productos.edit', 'productos.update', 'productos.destroy'])) {
                if (!in_array(Auth::user()->rol, ['administrador', 'supervisor'])) {
                    abort(403, 'Acceso no autorizado');
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
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
        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}