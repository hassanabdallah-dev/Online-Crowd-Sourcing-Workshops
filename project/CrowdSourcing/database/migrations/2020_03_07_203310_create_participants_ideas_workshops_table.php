<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsIdeasWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('participant_idea_original', function (Blueprint $table) {
            $table->unsignedBigInteger('id_participant');
            $table->unsignedBigInteger('id_idea');
            $table->timestamps();
            $table->index('id_participant');
            $table->foreign('id_participant')->references('id')->on('users')->onDelete('cascade');
            $table->index('id_idea');
            $table->foreign('id_idea')->references('id')->on('ideas')->onDelete('cascade');
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
            $table->dropForeign('participant_idea_original_id_participant_foreign');
            $table->dropForeign('participant_idea_original_id_participant_index');
            $table->dropColumn('id_participant');
            $table->dropForeign('participant_idea_original_id_idea_foreign');
            $table->dropForeign('participant_idea_original_id_idea_index');
            $table->dropColumn('id_idea');
            });
    }
}
