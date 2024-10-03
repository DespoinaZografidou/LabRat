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
        Schema::create('reject_team', function (Blueprint $table) {
            $table->id();
            $table->string('am');
            $table->bigInteger('at_id')->unsigned();
            $table->string('receiver_am');
            $table->boolean('confirm')->nullable();
            $table->foreign('at_id')->references('id')->on('activity_team')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reject_team');
    }

};
