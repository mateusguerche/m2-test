<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            [
                'id' => 1,
                'amount' => '200.00',
                'type' => 'value',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'amount' => '50.50',
                'type' => 'percentage',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
