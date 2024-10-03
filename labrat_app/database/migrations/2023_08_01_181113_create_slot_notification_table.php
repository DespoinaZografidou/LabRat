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
        Schema::create('slot_notification', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slot_id')->unsigned();
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade');
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
        Schema::dropIfExists('slot_notification');
    }
};
