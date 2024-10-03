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
        Schema::create('quiz_tries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aq_id')->unsigned();
            $table->foreign('aq_id')->references('id')->on('activity_quiz')->onDelete('cascade');
            $table->string('am');
            $table->bigInteger('finalscore');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_tries');
    }
};
