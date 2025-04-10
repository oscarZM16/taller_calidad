<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permite la solicitud si el usuario está autenticado.
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre'         => 'required|string|max:255',
            'descripcion'    => 'nullable|string',
            'stock'          => 'required|integer|min:0',
            'unidad_medida'  => 'required|string|max:50',
            'estado'         => 'required|in:activo,inactivo',
        ];
    }
}