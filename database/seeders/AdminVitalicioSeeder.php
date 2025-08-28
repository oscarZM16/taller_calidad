<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminVitalicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'santi_3007@hotmail.com'],
            [
                'name' => 'Santiago',
                'apellidos' => 'Velasco Cobo',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'rol' => 'administrador',
            ]
        );
    }
}
