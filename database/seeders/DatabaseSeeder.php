<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::updateOrCreate(
            ['email' => 'admin@sarengroup.test'],
            [
                'name' => 'Admin Saren Grup',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],
        );

        $this->call(ProductSeeder::class);
    }
}
