drop trigger if exists insert_participant_workshop;
delimiter $$
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
end$$
delimiter ;