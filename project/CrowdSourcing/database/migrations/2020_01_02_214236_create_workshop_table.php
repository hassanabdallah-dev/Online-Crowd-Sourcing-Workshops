<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('workshop', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->string('name');
            $table->string('location');
            $table->boolean('active')->default(false);
            $table->integer('nbparticipantsmax');
            $table->integer('nbparticipants')->default(0);
            $table->bigInteger('monitor_id')->required();
            $table->timestamps();
            $table->index('key');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql1')->dropIfExists('participant_idea_original',function(){
            $table->dropColumn('key');
        });
        Schema::connection('mysql1')->dropIfExists('participant_workshop');
        Schema::connection('mysql1')->dropIfExists('workshop');
    }
}
