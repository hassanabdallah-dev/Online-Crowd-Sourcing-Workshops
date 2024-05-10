use crowdcrowd;
drop procedure if exists procedure_insert_groups;
delimiter $$
create procedure procedure_insert_groups(workshop_key varchar(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci', monitor int, group_count int, total int)
begin
declare done boolean;
declare idd int;
declare part_max int;
declare cursor_group cursor for select `id` from `ideas` where `workshopsKey` = workshop_key order by `score` desc limit 5;
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
insert into `groups` (`monitor_id`, `idea_id`, `nbParticipants`, `nbParticipantsmax`, `workshop_key`) values (monitor , idd, 0, part_max, workshop_key);
END LOOP;
close cursor_group;
end$$
delimiter ;