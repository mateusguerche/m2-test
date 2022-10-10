<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaigns')->insert([
            [
                'id' => 1,
                'name' => 'Campanha 1.1',
                'city_group_id' => 1,
                'discount_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Camapanha 1.2',
                'city_group_id' => 1,
                'discount_id' => 2,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Campanha 2.1',
                'city_group_id' => 2,
                'discount_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Camapanha 2.2',
                'city_group_id' => 2,
                'discount_id' => 2,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
