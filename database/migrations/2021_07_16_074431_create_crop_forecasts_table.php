<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->enum('model',[1,2,3]);
            $table->unsignedBigInteger('year');
            $table->decimal('area',25,15)->default(0);
            $table->decimal('yield',25,15)->default(0);
            $table->decimal('production',25,15)->default(0);
            $table->decimal('p_seed_ratio',25,15)->default(0);
            $table->decimal('per_capita_consumption_kg_yr',25,15)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crop_forecasts');
    }
}
