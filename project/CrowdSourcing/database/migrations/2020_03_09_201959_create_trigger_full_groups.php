<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggerFullGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
        drop trigger if exists trigger_full_groups;
        create trigger trigger_full_groups before update on `group`
        for each row
        begin
        if NEW.nbParticipants <> OLD.nbParticipants then
        if NEW.nbParticipants = NEW.nbParticipantsmax then
            set NEW.`full` = 1;
        end if;
        if OLD.`full` = 1 and NEW.nbParticipants < NEW.nbParticipantsmax then
                set NEW.`full` = 0;
        end if;
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
        Schema::connection('mysql1')->dropIfExists('trigger_full_groups');
    }
}
