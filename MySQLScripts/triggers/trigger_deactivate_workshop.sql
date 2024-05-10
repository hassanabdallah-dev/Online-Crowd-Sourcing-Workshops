use crowdcrowd;
drop trigger if exists trigger_deactivate_workshop;
delimiter $$
create trigger trigger_deactivate_workshop after update on `group`
for each row
begin
declare registered int;
declare _all int;
declare msg varchar(45);
declare deac boolean;
select exists( select null  from preferences where `name` = 'workshop-deactivate' and `enable` = true) into deac;

if deac = 1 and NEW.nbParticipants <> OLD.nbParticipants then
select sum(`nbParticipants`) into registered from `group`
where `workshop_id`= NEW.workshop_id;
select `nbparticipants` into _all from `workshop`
where `id`= NEW.workshop_id;
if _all = registered then
update `workshop`
set `active` = 0
where `id` = NEW.workshop_id;
end if;
end if;
end$$
delimiter ;