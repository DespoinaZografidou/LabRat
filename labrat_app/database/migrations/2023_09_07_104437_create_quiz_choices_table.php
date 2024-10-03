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
        Schema::create('quiz_choices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qq_id')->unsigned();
            $table->foreign('qq_id')->references('id')->on('quiz_questions')->onDelete('cascade');
            $table->bigInteger('t_id')->unsigned();
            $table->foreign('t_id')->references('id')->on('quiz_tries')->onDelete('cascade');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_choices');
    }
};
