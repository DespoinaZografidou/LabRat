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
        Schema::create('determinate_themes_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dt_id')->unsigned();
            $table->foreign('dt_id')->references('id')->on('determinate_themes')->onDelete('cascade');
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
        Schema::dropIfExists('determinate_themes_notifications');
    }
};
