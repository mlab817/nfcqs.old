<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->decimal('area',25,15)->default(0);
            $table->decimal('yield',25,15)->default(0);
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
        Schema::dropIfExists('shifters');
    }
}
