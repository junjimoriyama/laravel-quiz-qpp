<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Level::insert([
            ['key' => 'basic', 'label' => '初級'],
            ['key' => 'mid',   'label' => '中級'],
            ['key' => 'pro',   'label' => '上級'],
        ]);
    }
}
