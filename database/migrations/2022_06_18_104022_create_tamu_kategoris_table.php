<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamu_kategoris', function (Blueprint $table) {
            $table->id('number');
            $table->unsignedBigInteger('tamus_number');
            $table->unsignedBigInteger('kategoris_number');

            $table->foreign('tamus_number')->references('number')->on('tamus');
            $table->foreign('kategoris_number')->references('number')->on('kategoris');
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
        Schema::dropIfExists('tamu_kategoris');
    }
};
