use crowdcrowd;
drop trigger if exists trigger_create_groups;
delimiter $$
create trigger trigger_create_groups after update on ideas
for each row
begin
declare total int;
declare pref int;
declare vote int;
declare part_total int;
declare group_count int;
declare msg varchar(45);
declare idd int;
declare id_monitor int;
declare done int;
declare nideas int;
declare cursor_group cursor for select id from ideas where workshop_id = NEW.workshop_id order by score desc limit 5;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
set pref = 0;
if NEW.voted <> OLD.voted then
set done = 0;
select monitor_id into id_monitor from workshop where `id` = NEW.workshop_id;
select count(*) into total from ideas where workshop_id = NEW.workshop_id;
select `value` into pref from preferences where `name` = 'rounds-number' and `enable` = true;
if total > 5 then
set group_count = 5;
set part_total = total;
else
set part_total = total;
set group_count = total;
end if;
if pref > 0 and pref < total then
set total = pref;
else
set total = total - 1;
end if;
select count(*) into vote from ideas where workshop_id = NEW.workshop_id and voted = total;
select count(*) into nideas from ideas where workshop_id = NEW.workshop_id;
if vote = nideas then
call procedure_insert_groups(NEW.workshop_id, id_monitor, group_count, part_total);
end if;
end if;
end$$
delimiter ;