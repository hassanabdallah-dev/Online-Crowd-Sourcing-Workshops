<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('idea_participant', function (Blueprint $table) {
            $table->unsignedBigInteger('participants_id');
            $table->unsignedBigInteger('idea_id')->nullable();
            $table->timestamps();
            $table->index('participants_id');
            $table->foreign('participants_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('idea_id');
            $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql1')->dropIfExists('idea_paraticipant',function(){
            $table->dropForeign('idea_participant_participants_id_foreign');
            $table->dropIndex('idea_participant_participants_id_index');
            $table->dropColumn('participants_id');
            $table->dropForeign('idea_participant_idea_id_foreign');
            $table->dropIndex('idea_participant_idea_id_index');
            $table->dropColumn('idea_id');
            });
    }
}
