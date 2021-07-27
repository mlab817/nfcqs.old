<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('src_province_id')->constrained();
            $table->foreignId('src_commodity_id')->constrained();
            $table->decimal('conversion_rate',25,15)->default(0);
            $table->string('crop_data_filename',100)->nullable();
            $table->string('pop_data_filename',100)->nullable();
            $table->decimal('per_capita_consumption_kg_year',25,15)->default(0);
            $table->year('per_capita_year')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('crops');
    }
}
