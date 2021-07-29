<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_data', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->foreignId('src_province_id')->constrained();
            $table->foreignId('src_commodity_id')->constrained();
            $table->decimal('production', 25, 15)->nullable();
            $table->decimal('area_harvested', 25, 15)->nullable();
            $table->decimal('yield', 25, 15)->nullable();
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
        Schema::dropIfExists('official_data');
    }
}
