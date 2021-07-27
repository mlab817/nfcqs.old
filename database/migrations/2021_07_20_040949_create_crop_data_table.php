<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->unsignedBigInteger('year');
            $table->decimal('harvested_area_ha',25,15)->default(0);
            $table->decimal('production_mt',25,15)->default(0);
            $table->decimal('yield_mt_ha',25,15)->default(0);
            $table->decimal('converted_area',25,15)->default(0);
            $table->decimal('converted_prod',25,15)->default(0);
            $table->decimal('converted_yield',25,15)->default(0);
            $table->decimal('per_capita_consumption_kg_year',25,15)->default(0);
            $table->decimal('ln_area',25,15)->default(0);
            $table->decimal('ln_yield',25,15)->default(0);
            $table->decimal('ln_consumption',25,15)->default(0);
            $table->foreignId('src_commodity_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('source',['user','system'])->nullable();
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
        Schema::dropIfExists('crop_data');
    }
}
