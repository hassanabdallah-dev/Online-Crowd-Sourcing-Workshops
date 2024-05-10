<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerDeleteUsersGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
            drop trigger if exists delete_users_group;
            create trigger delete_users_group after delete on `users_group`
            for each row
            begin
            update `group`
            set `nbParticipants` = `nbParticipants` - 1
            where `id` = OLD.`group_id` and `nbParticipants` > 0;
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
        Schema::connection('mysql1')->dropIfExists('delete_users_group');
    }
}
