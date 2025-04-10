<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permite que todos los usuarios autorizados usen esta request
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'unidad_medida' => 'required|string|max:50',
            'estado' => 'required|in:activo,inactivo',
        ];
    }
}

