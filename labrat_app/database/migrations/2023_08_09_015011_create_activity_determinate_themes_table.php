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
        Schema::create('activity_determinate_themes', function (Blueprint $table) {
            $table->id();
            $table->uuid('l_id');
            $table->foreign('l_id')->references('l_id')->on('lessons')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->timestamps();
            $table->bigInteger('at_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_determinate_themes');
    }
};
