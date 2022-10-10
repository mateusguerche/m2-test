<?php

namespace Database\Seeders;

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
        $this->call([
            CityGroupSeeder::class,
            CitySeeder::class,
            DiscountSeeder::class,
            ProductSeeder::class,
            CampaignSeeder::class,
            CampaignProductSeeder::class,
        ]);
    }
}
