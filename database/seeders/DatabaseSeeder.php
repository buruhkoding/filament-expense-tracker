<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'madfizh',
            'email' => 'madfizh@mail.com',
            'password' => 'asu123'
        ]);

        Wallet::insert([
            [
                'name' => 'SeaBank',
                'type' => 'bank',
            ],
            [
                'name' => 'Cash',
                'type' => 'cash',
            ],
            [
                'name' => 'Gold',
                'type' => 'investment',
            ],
        ]);

        Category::insert([
            [
                'name' => 'Foods',
                'icon' => '🍴',
                'type' => 'expense',
            ],
            [
                'name' => 'Gift',
                'icon' => '🎁',
                'type' => 'expense',
            ],
            [
                'name' => 'Sallary',
                'icon' => '💰',
                'type' => 'income',
            ],
            [
                'name' => 'Freelance',
                'icon' => '🎯',
                'type' => 'income',
            ],
        ]);
    }
}
