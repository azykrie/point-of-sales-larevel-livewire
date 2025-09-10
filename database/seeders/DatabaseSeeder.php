<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(50)->create();
        // Category::factory(20)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin123@gmail.com',
            'password' => 'admin123',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'warehouse',
            'email' => 'warehouse123@gmail.com',
            'password' => 'warehouse123',
            'role' => 'warehouse'
        ]);
    }
}
