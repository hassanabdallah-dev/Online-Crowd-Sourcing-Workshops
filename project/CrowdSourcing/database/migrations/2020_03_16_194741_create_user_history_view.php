<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
        create view userhistory as
            select `participant_id`, `name`, `location`, `workshop`.`created_at`
            from `workshop`, `participant_workshop`
            where `id` = `workshop_id`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql1')->unprepared("drop view if exists userhistory");
    }
}
