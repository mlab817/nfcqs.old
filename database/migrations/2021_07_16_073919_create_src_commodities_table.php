<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrcCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('src_commodities', function (Blueprint $table) {
            $table->id();
            $table->string('commodity');
            $table->enum('crop_type',['Crop','Non-Crop']);
            $table->decimal('seed_ratio',4,3);
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
        Schema::dropIfExists('src_commodities');
    }
}
