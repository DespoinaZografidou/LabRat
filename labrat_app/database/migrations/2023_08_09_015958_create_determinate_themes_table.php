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
        Schema::create('determinate_themes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('adt_id')->unsigned();
            $table->foreign('adt_id')->references('id')->on('activity_determinate_themes')->onDelete('cascade');
            $table->bigInteger('j_id')->unsigned();
            $table->foreign('j_id')->references('id')->on('journals')->onDelete('cascade');
            $table->string('title');
            $table->string('am');
            $table->boolean('confirm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('determinate_themes');
    }
};
