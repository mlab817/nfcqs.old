<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        if (! User::where('email', 'mlab817@gmail.com')->exists()) {
            User::create([
                'office' => 'IPD',
                'full_name' => 'Mark Lester A. Bolotaolo',
                'password' => Hash::make('password'),
                'email' => 'mlab817@gmail.com'
            ]);
        }

        $this->call(SrcCommoditiesTableSeeder::class);
        $this->call(SrcProvincesTableSeeder::class);
        Crop::factory()->count(5)->create();
    }
}
