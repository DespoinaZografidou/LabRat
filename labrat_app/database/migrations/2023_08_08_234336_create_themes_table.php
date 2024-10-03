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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ct_id')->unsigned();
            $table->foreign('ct_id')->references('id')->on('activity_choose_theme')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->text('file');
            $table->boolean('excusive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
};
