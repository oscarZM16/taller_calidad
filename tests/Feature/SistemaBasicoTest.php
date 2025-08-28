<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SistemaBasicoTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Crear usuario vitalicio
        User::factory()->create([
            'name' => 'Santiago',
            'apellidos' => 'Velasco Cobo',
            'email' => 'santi_3007@hotmail.com',
            'password' => Hash::make('123456'),
            'rol' => 'administrador',
        ]);
    }

    public function test_usuario_vitalicio_puede_iniciar_sesion_y_acceder()
    {
        // Intentamos iniciar sesión con el usuario vitalicio previamente creado usando sus credenciales reales
        $response = $this->post('/login', [
            'email' => 'santi_3007@hotmail.com',
            'password' => '123456',
        ]);

        // Verificamos que el sistema redirige correctamente después del login y que el usuario quedó autenticado
        $response->assertRedirect('/users'); // Ajusta si redirige a otro lado
        $this->assertAuthenticated();

        $usuario = auth()->user();
        $this->assertEquals('administrador', $usuario->rol);
        
        echo "\n✅ Login exitoso para el usuario vitalicio.\n";
        echo "→ Rol autenticado: " . $usuario->rol . "\n";
        echo "→ Redirigido correctamente a /users\n";

        // Verificamos que puede acceder correctamente a la ruta protegida para administradores (/users)
        $response = $this->get('/users');
        $response->assertStatus(200);
    }
}