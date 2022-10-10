<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaign_products')->insert([
            [
                'id' => 1,
                'campaign_id' => 1,
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'campaign_id' => 2,
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'campaign_id' => 1,
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'campaign_id' => 2,
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'campaign_id' => 3,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'campaign_id' => 3,
                'product_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'campaign_id' => 4,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'campaign_id' => 4,
                'product_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
