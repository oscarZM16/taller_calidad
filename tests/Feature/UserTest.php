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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@correo.com',
            'password' => 'clave123',
            'rol' => 'funcionario',
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@correo.com',
            'rol' => 'funcionario',
        ]);
    }

    /** @test */
    public function administrador_puede_crear_un_usuario_con_rol_especifico()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/users', [
            'name' => 'Nuevo Admin',
            'email' => 'nuevoadmin@correo.com',
            'password' => 'clave123',
            'rol' => 'administrador',
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'email' => 'nuevoadmin@correo.com',
            'rol' => 'administrador',
        ]);
    }

    /** @test */
    public function no_se_puede_crear_usuario_sin_email()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/users', [
            'name' => 'Sin Correo',
            'password' => 'clave123',
            'rol' => 'funcionario',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
