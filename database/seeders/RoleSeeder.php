<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $roles = [
        //      [
        //          //
        //      ]
        // ];

        // foreach ($roles as $role) {
        //     Role::create($role);
        // }

        // Role::factory()->count(10)->create();

        Role::create([
            'name' => 'Admin',
            'description' => 'Peran ini mengatur semua hal yang berhubungan dengan operasional aplikasi',
            'is_active' => true,
            'color' => '#500073'
        ]);
        Role::create([
            'name' => 'Focal Point',
            'description' => 'Peran ini bertugas memanajemen data dan informasi',
            'is_active' => true,
            'color' => '#344CB7'
        ]);
    }
}
