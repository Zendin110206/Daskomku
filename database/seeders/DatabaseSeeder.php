<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Configuration::factory(20)->create();
        \App\Models\Announcement::factory(3)->create();
        \App\Models\Plottingan::factory(20)->create();
        \App\Models\CaasStage::factory(20)->create();
        \App\Models\Caas::factory(20)->create();


        \App\Models\User::factory()->create([
            'nim' => '1234',
            'password' => '1234',
            'is_admin' => true,
        ]);
    }
}
