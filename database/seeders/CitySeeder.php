<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // Используем фабрику для создания 10 городов
        City::factory()->count(10)->create();
    }
}
