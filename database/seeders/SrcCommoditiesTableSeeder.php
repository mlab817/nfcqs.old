<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SrcCommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commodities = [
            ['Rice','Crop'],
            ['Sweet Potato','Crop'],
            ['Squash','Crop'],
            ['Mungbean','Crop'],
            ['Papaya','Crop'],
            ['Coconut','Crop'],
            ['Hogs','Non-Crop'],
            ['Chicken Eggs','Non-Crop'],
            ['Tilapia','Non-Crop'],
        ];

        foreach ($commodities as $commodity) {
            DB::table('src_commodities')->insert([
                'commodity' => $commodity[0],
                'crop_type' => $commodity[1],
                'seed_ratio'=> 0,
            ]);
        }
    }
}
