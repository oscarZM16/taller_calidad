<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_administrador_puede_iniciar_sesion()
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Santi Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador'
        ]);

        // Intentar login
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        // Verificar redirección y autenticación
        $response->assertRedirect('/'); // o a donde redirige tu login
        $this->assertAuthenticatedAs($admin);
        $this->assertEquals('administrador', auth()->user()->rol);
    }
}