<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerInsertParticipantWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
            drop trigger if exists insert_participant_workshop;
            create trigger insert_participant_workshop before insert on `participant_workshop`
            for each row
            begin
            declare exceeded int;
            select exists(select null from `workshop` where `id` = NEW.`workshop_id` and `nbparticipants` >= `nbparticipantsmax`) into exceeded;
            if exceeded = 1 then
            signal sqlstate '40001' set message_text ='cannot insert participant in a full workshop';
            else
            update `workshop`
            set `nbparticipants` = `nbparticipants` + 1
            where `id` = NEW.`workshop_id`;
            end if;
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
        Schema::connection('mysql1')->dropIfExists('insert_participant_workshop');
    }
}
