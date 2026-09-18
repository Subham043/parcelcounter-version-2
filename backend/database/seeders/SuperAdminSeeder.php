<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Features\Roles\Enums\Roles;
use App\Features\Users\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // create admin
        User::factory()->create([
            'name' => 'Subham Saha',
            'email' => 'subham@gmail.com',
            'phone' => '7892156161',
            'password' => 'subham',
            'is_blocked' => 0,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ])->syncRoles([Roles::SuperAdmin->value()]);
    }
}
