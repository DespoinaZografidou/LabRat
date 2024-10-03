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
        Schema::create('activity_quiz', function (Blueprint $table) {
            $table->id();
            $table->uuid('l_id');
            $table->foreign('l_id')->references('l_id')->on('lessons')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->timestamps();
            $table->integer('tries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_quiz');
    }
};
