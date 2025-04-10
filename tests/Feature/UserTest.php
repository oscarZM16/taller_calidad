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
        $usuarioExistente = User::create([
            'name' => 'UsuarioExistente',
            'email' => 'existente@test.com',
            'password' => Hash::make('123456'),
            'rol' => 'administrador',
        ]);

        $funcionario = User::create([
            'name' => 'Funcionario',
            'email' => 'funcionario@test.com',
            'password' => Hash::make('clave123'),
            'rol' => 'funcionario',
        ]);

        $this->actingAs($funcionario);

        $this->get('/users/create')
            ->assertRedirect('/users')
            ->assertSessionHas('error', 'Acceso denegado');

        $this->post('/users', [
            'name' => 'Hackeado',
            'email' => 'hack@correo.com',
            'password' => '123456',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseMissing('users', ['email' => 'hack@correo.com']);

        $this->get("/users/{$usuarioExistente->id}/edit")
            ->assertStatus(403);

        $this->delete("/users/{$usuarioExistente->id}")
            ->assertRedirect('/users')
            ->assertSessionHas('error', 'No tienes permiso para eliminar usuarios.');

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

        $this->post('/users', [
            'name' => 'NuevoUsuario',
            'email' => 'nuevo@correo.com',
            'password' => 'clave123',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'nuevo@correo.com']);

        $nuevo = User::where('email', 'nuevo@correo.com')->first();

        $this->put("/users/{$nuevo->id}", [
            'name' => 'UsuarioActualizado',
            'email' => 'nuevo@correo.com',
            'password' => 'clave1234',
            'rol' => 'supervisor',
        ]);
        $this->assertDatabaseHas('users', ['name' => 'UsuarioActualizado']);

        $this->delete("/users/{$nuevo->id}");
        $this->assertDatabaseMissing('users', ['email' => 'nuevo@correo.com']);
    }
}