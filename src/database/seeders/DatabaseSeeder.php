<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Auth\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserModel::factory()
            ->withPassword()
            ->create([
                'name' => 'Usuario Prueba',
                'email' => 'test@example.com',
            ]);
    }
}
