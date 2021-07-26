<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->enum('model',['ltt','cagr','arima']); // 1, 2, 3 - ltt is 1, cagr is 2, arima is 3
            $table->year('year');
            $table->decimal('actual', 25, 15)->default(0);
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
        Schema::dropIfExists('forecasts');
    }
}
