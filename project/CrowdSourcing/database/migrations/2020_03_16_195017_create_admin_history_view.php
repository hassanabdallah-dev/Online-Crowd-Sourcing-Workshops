<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
        drop view if exists adminhistory;
        create view adminhistory as select `users`.`name` as `monitor`,  `nbparticipants`, `workshop`.`name`, `location`, `workshop`.`created_at`
            from `workshop`,`users`
            where `monitor_id` = `users`.`id`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql1')->unprepared('drop view if exists adminhistory');
    }
}
