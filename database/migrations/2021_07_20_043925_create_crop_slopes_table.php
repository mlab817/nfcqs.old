<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropSlopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_slopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->decimal('area',25,15)->default(0);
            $table->decimal('yield',25,15)->default(0);
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
        Schema::dropIfExists('crop_slopes');
    }
}
