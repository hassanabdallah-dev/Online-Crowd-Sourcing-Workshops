<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureInsertGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql1')->unprepared("
drop procedure if exists procedure_insert_groups;
create procedure procedure_insert_groups(workshop_id int, monitor int, group_count int, total int)
begin
declare done boolean;
declare idd int;
declare part_max int;
declare cursor_group cursor for select `id` from `ideas` where `workshop_id` = workshop_id order by `score` desc limit 5;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
if total % group_count <> 0 then
set part_max = floor(total/group_count) + 1;
else
set part_max = floor(total/group_count);
end if;
open cursor_group;
myloop: LOOP
fetch cursor_group into idd;
IF done THEN
	LEAVE myloop;
END IF;
insert into `group` (`monitor_id`, `idea_id`, `nbParticipants`, `nbParticipantsmax`, `workshop_id`) values (monitor , idd, 0, part_max, workshop_id);
END LOOP;
close cursor_group;
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
        Schema::connection('mysql1')->dropIfExists('procedure_insert_groups');
    }
}
