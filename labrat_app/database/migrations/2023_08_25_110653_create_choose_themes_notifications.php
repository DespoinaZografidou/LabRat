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
        Schema::create('choose_themes_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('th_id')->unsigned();
            $table->foreign('th_id')->references('id')->on('themes')->onDelete('cascade');
            $table->text('msg');
            $table->string('receiver_am');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('choose_themes_notifications');
    }
};
