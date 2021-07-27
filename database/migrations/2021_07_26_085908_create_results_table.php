<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->year('year');
            $table->decimal('ltt_production', 25, 15)->nullable();
            $table->decimal('cagr_production', 25, 15)->nullable();
            $table->decimal('arima_production', 25, 15)->nullable();
            $table->decimal('consumption', 25, 15)->nullable();
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
        Schema::dropIfExists('results');
    }
}
