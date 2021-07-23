<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonCropForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_crop_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->enum('model',[1,2,3]);
            $table->integer('year');
            $table->decimal('production',25,15)->default(0);
            $table->decimal('per_capita_consumption_kg_yr',25,15)->default(0);
            $table->decimal('consumption',25,15)->default(0);
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
        Schema::dropIfExists('non_crop_forecasts');
    }
}
