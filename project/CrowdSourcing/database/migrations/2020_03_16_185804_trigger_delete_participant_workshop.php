<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerDeleteParticipantWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
            drop trigger if exists delete_participant_workshop;
            create trigger delete_participant_workshop after delete on `participant_workshop`
            for each row
            begin
            update `workshop`
            set `nbparticipants` = `nbparticipants` - 1
            where `id` = OLD.`workshop_id` and `nbparticipants` > 0;
            end
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql1')->dropIfExists('delete_participant_workshop');
    }
}
