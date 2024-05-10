<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idea_id');
            $table->unsignedBigInteger('monitor_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('nbParticipants');
            $table->unsignedBigInteger('nbParticipantsmax');
            $table->boolean('full')->default(false);
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
        Schema::connection('mysql1')->dropIfExists('group');
    }
}
