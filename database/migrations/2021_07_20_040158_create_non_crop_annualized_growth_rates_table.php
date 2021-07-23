<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonCropAnnualizedGrowthRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_crop_annualized_growth_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->decimal('production',25,15)->default(0);
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
        Schema::dropIfExists('non_crop_annualized_growth_rates');
    }
}
