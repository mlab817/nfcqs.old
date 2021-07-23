<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\SrcCommodity;
use App\Models\SrcProvince;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'src_province_id' => SrcProvince::all()->random()->id,
            'src_commodity_id' => SrcCommodity::all()->random()->id,
            'conversion_rate' => $this->faker->randomFloat(2,0,1),
            'crop_data_filename' => $this->faker->sentence,
            'pop_data_filename' => $this->faker->sentence,
            'per_capita_consumption_kg_year' => $this->faker->numberBetween(30,150),
            'per_capita_year' => $this->faker->numberBetween(1987,2021),
            'remarks' => $this->faker->paragraph,
        ];
    }
}
