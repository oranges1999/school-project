<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use App\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456',
        ]);

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456',
            'role' => Role::ADMIN,
        ]);

        Admin::create([
            'name' => 'Shipper',
            'email' => 'shipper@example.com',
            'password' => '123456',
            'role' => Role::SHIPPER
        ]);

        Category::create(['name' => 'Fryer']);
        Category::create(['name' => 'Hot pot']);
        Category::create(['name' => 'Heater']);
        Category::create(['name' => 'Iron']);
        Category::create(['name' => 'Hydroelectric Tank']);
    }
}
