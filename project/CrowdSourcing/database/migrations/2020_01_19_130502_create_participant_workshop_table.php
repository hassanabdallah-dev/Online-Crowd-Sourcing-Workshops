<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantWorkshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('participant_workshop', function (Blueprint $table) {
            $table->unsignedBigInteger('participant_id')->required();
            $table->unsignedBigInteger('workshop_id')->required();
            $table->timestamps();

            $table->index('participant_id');
            $table->foreign('participant_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('workshop_id');
            $table->foreign('workshop_id')->references('id')->on('workshop')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection('mysql1')->dropIfExists('participant_workshop',function(){
            $table->dropForeign('participant_workshop_participant_id_foreign');
            $table->dropIndex('participant_workshop_participant_id_index');
            $table->dropColumn('participant_id');
            $table->dropForeign('participant_workshop_workshop_id_foreign');
            $table->dropIndex('participant_workshop_workshop_id_index');
            $table->dropColumn('workshop_id');
            });
    }
}
