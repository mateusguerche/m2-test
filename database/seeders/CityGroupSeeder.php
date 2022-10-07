<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CityGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city_groups')->insert([
            [
                'id' => 1,
                'name' => 'Grupo 1',
                'slug' => Str::slug('Grupo 1', '-')
            ],
            [
                'id' => 2,
                'name' => 'Grupo 2',
                'slug' => Str::slug('Grupo 2', '-')
            ]
        ]);
    }
}
