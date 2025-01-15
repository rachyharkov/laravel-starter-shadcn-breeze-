<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\{Role, User, UserRole};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Rachmad Nur Hayat',
            'username' => 'admin',
            'email' => 'test@example.com',
            // 'branch_id' => 1,
            'gender' => 'MALE',
            'password' => Hash::make('password'),
        ]);

        UserRole::create([
            'role_id' => 1,
            'user_id' => $admin->id
        ]);

        $users = [];
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 15; $i++) {
            $users[] = [
                // 'branch_id' => 1,
                // 'id' => strtolower(str()->random(5)),
                'name' => $faker->name(),
                'gender' => $faker->randomElement(['MALE', 'FEMALE']),
                'code' => $faker->randomNumber(8),
                'birth_date' => $faker->date(),
                'birth_place' => $faker->city(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'username' => $faker->userName() . $i,
                'email' => $i . $faker->email(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($users as $user) {
            $createdUser = User::create($user);

            UserRole::create([
                'role_id' => 2,
                'user_id' => $createdUser->id,
                'is_active' => rand(0, 1)
            ]);

        }
    }
}
