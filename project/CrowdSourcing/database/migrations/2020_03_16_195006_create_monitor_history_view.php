<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
        create view monitorhistory as select `monitor_id`, `nbparticipants`, `name`, `location`, `workshop`.`created_at`
            from `workshop`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql1')->unprepared('drop view if exists monitorhistory');
    }
}
