<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_administrador_puede_crear_un_usuario()
    {
        // Crear un usuario administrador
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        // Simular que estamos autenticados como ese admin
        $this->actingAs($admin);

        // Simular la creación de un nuevo usuario
        $response = $this->post('/users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@correo.com',
            'password' => 'clave123',
            'rol' => 'funcionario',
        ]);

        // Verifica que se redirige a la lista
        $response->assertRedirect('/users');

        // Verifica que el usuario fue creado
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@correo.com',
            'rol' => 'funcionario',
        ]);
    }
}
