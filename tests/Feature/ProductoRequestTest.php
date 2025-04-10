<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProductoRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_permite_crear_producto_con_nombre_vacio()
    {
        $user = User::factory()->create(['rol' => 'administrador']);
        $this->actingAs($user);

        $response = $this->post('/productos', [
            'nombre' => '',
            'descripcion' => 'Insumo sin nombre',
            'stock' => 10,
            'unidad_medida' => 'kg',
            'estado' => 'activo',
        ]);

        $response->assertSessionHasErrors(['nombre']);
    }
}
