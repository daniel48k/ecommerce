<?php

namespace Database\Seeders;

use App\Constants\RoleConstants;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Database\Factories\Sub_categoryFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => RoleConstants::ADMIN
        ]);
        $client = User::create([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => RoleConstants::CLIENT
        ]);

        (new CategoryFactory())->count(10)->create();
        (new Sub_categoryFactory())->count(20)->create();
        (new ProductFactory())->count(20)->create();

    }
}
