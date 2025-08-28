<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function administrador_puede_ver_insumos()
    {
        $admin = User::factory()->create(['rol' => 'administrador']);
        $this->actingAs($admin)
             ->get('/insumos')
             ->assertStatus(200);
    }

    /** @test */
    public function supervisor_puede_ver_insumos()
    {
        $supervisor = User::factory()->create(['rol' => 'supervisor']);
        $this->actingAs($supervisor)
             ->get('/insumos')
             ->assertStatus(200);
    }

    /** @test */
    public function funcionario_no_puede_ver_insumos()
    {
        $funcionario = User::factory()->create(['rol' => 'funcionario']);
        $this->actingAs($funcionario)
             ->get('/insumos')
             ->assertRedirect('/users'); // redirecciona con error
    }
}