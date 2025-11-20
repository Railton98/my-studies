<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\User;
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
        User::factory()
            ->withoutTwoFactor()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        Content::factory(10)->create();
        Content::factory(10)
            ->series()
            ->active()
            ->create();
    }
}
