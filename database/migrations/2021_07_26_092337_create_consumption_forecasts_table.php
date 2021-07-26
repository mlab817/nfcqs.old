<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->year('year');
            $table->unsignedBigInteger('population')->default(0);
            $table->decimal('per_capita_consumption_kg_year', 25, 15)->default(0);
            $table->decimal('prediction', 25, 15)->default(0);
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
        Schema::dropIfExists('consumption_forecasts');
    }
}
