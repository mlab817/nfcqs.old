<?php

namespace Database\Seeders;

use App\Models\SrcProvince;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SrcProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            'Ilocos Norte',
            'Ilocos Sur',
            'La Union',
            'Pangasinan',
            'Batanes',
            'Cagayan',
            'Isabela',
            'Nueva Vizcaya',
            'Quirino',
            'Aurora',
            'Bataan',
            'Bulacan',
            'Pampanga',
            'Tarlac',
            'Zambales',
            'Nueva Ecija',
            'Cavite',
            'Laguna',
            'Batangas',
            'Rizal',
            'Quezon',
            'Occidental Mindoro',
            'Oriental Mindoro',
            'Marinduque',
            'Romblon',
            'Palawan',
            'Camarines Norte',
            'Camarines Sur',
            'Catanduanes',
            'Masbate',
            'Sorsogon',
            'Albay',
            'Aklan',
            'Antique',
            'Guimaras',
            'Capiz',
            'Iloilo',
            'Negros Occidental',
            'Bohol',
            'Cebu',
            'Siquijor',
            'Negros Oriental',
            'Biliran',
            'Leyte',
            'Northern Samar',
            'Samar',
            'Southern Leyte',
            'Eastern Samar',
            'Zamboanga Del Norte',
            'Zamboanga del Sur',
            'Zamboanga Sibugay',
            'Camiguin',
            'Bukidnon',
            'Lanao Del Norte',
            'Misamis Oriental',
            'Misamis Occidental',
            'Compostela Valley',
            'Davao del Norte',
            'Davao del Sur',
            'Davao Oriental',
            'Davao Occidental',
            'South Cotabato',
            'Cotabato',
            'Sultan Kudarat',
            'Sarangani',
            'Agusan del Norte',
            'Agusan del Sur',
            'Surigao del Norte',
            'Surigao del Sur',
            'Dinagat Islands',
            'Apayao',
            'Abra',
            'Benguet',
            'Ifugao',
            'Kalinga',
            'Mountain Province',
            'Basilan',
            'Lanao del Sur',
            'Maguindanao',
            'Sulu',
            'Tawi-Tawi',
        ];

        foreach ($provinces as $province) {
            DB::table('src_provinces')->insert([
                'province' => $province,
            ]);
        }
    }
}
