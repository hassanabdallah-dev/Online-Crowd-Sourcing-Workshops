<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('ideas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('participant_id');
            $table->string('workshop_id');
            $table->string('idea');
            $table->boolean('flag')->default(false);
            $table->integer('voted')->default(0);
            $table->integer('score');
            $table->integer('taken');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection('mysql1')->dropIfExists('participant_idea_original');
        Schema::connection('mysql1')->dropIfExists('idea_participant');
        Schema::connection('mysql1')->dropIfExists('ideas');
    }
}
