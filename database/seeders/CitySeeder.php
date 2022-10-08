<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            [
                'id' => 1,
                'name' => 'São Paulo',
                'state' => 'SP',
                'city_group_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Rio de Janeiro',
                'state' => 'RJ',
                'city_group_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
