<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            ['name' => 'Dev'],
            ['name' => 'Designer'],
            ['name' => 'Security'],
            ['name' => 'Driver'],
        ]);
        \App\Models\User::factory(45)->create();
    }
}
