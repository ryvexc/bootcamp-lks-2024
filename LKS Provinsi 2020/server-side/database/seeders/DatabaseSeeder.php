<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            "username" => "ryve",
            "password" => "12345678"
        ]);

        for ($i = 0; $i < 10; $i++) {
            $player = new Player();
            $player->posisi = "Posisitest";
            $player->nama = fake()->name();
            $player->nomor_punggung = rand(1, 99);
            $player->created_by_id = 1;
            $player->modified_by_id = 1;
            $player->save();
        }
    }
}
