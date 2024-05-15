<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'luka',
            'last_name' => 'kurdadze',
            'email' => 'lukakurdadze2@gmail.com',
            'image' => fake()->imageUrl(200, 200),
            'password' => bcrypt('password'),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'image' => fake()->imageUrl(200, 200),
            ]);

            UserContact::factory()->create([
                'user_id' => 1,
                'contact_id' => $i + 1,
                'accepted' => true,
            ]);

            $conversation = Conversation::factory()->create([
                'uuid' => Str::uuid(),
            ]);

            $conversation->members()->attach([1, $i + 1]);
        }


    }
}
