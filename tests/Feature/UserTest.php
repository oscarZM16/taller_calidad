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
    public function un_funcionario_no_puede_crear_eliminar_ni_editar_usuarios()
    {
        // Crear un usuario ya existente en la base
        $usuarioExistente = User::create([
            'name' => 'Usuario Existente',
            'email' => 'existente@test.com',
            'password' => Hash::make('123456'),
            'rol' => 'administrador',
        ]);

        // Crear un funcionario
        $funcionario = User::create([
            'name' => 'Funcionario',
            'email' => 'funcionario@test.com',
            'password' => Hash::make('clave123'),
            'rol' => 'funcionario',
        ]);

        $this->actingAs($funcionario);

        // Intentar acceder al formulario de creación
        $this->get('/users/create')
            ->assertRedirect('/users')
            ->assertSessionHas('error', 'Acceso denegado');

        // Intentar crear usuario (POST)
        $this->post('/users', [
            'name' => 'Hackeado',
            'email' => 'hack@correo.com',
            'password' => '123456',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseMissing('users', ['email' => 'hack@correo.com']);

        // Intentar acceder al formulario de edición
        $this->get("/users/{$usuarioExistente->id}/edit")
            ->assertStatus(403); // si tienes esta protección, o redirige a users

        // Intentar eliminar usuario
        $this->delete("/users/{$usuarioExistente->id}")
            ->assertRedirect('/users')
            ->assertSessionHas('error', 'No tienes permiso para eliminar usuarios.');

        // Verificar que el usuario no fue eliminado
        $this->assertDatabaseHas('users', ['email' => 'existente@test.com']);
    }

    /** @test */
    public function un_administrador_puede_crear_editar_y_eliminar_usuarios()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        $this->actingAs($admin);

        // Crear usuario
        $this->post('/users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@correo.com',
            'password' => 'clave123',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'nuevo@correo.com']);

        $nuevo = User::where('email', 'nuevo@correo.com')->first();

        // (Simular) Actualizar usuario (esto depende de que tengas el método 'update')
        $this->put("/users/{$nuevo->id}", [
            'name' => 'Usuario Actualizado',
            'email' => 'nuevo@correo.com',
            'password' => 'clave1234',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseHas('users', ['name' => 'Usuario Actualizado']);

        // Eliminar usuario
        $this->delete("/users/{$nuevo->id}");
        $this->assertDatabaseMissing('users', ['email' => 'nuevo@correo.com']);
    }
}
