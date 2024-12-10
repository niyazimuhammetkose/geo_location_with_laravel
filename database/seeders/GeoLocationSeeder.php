<?php

namespace Database\Seeders;

use App\Models\GeoLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeoLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeoLocation::factory(10)->create();
    }
}
