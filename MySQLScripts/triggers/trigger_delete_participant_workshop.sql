drop trigger if exists delete_participant_workshop;
delimiter $$
create trigger delete_participant_workshop after delete on `participant_workshop` 
for each row
begin
update `workshop` 
set `nbparticipants` = `nbparticipants` - 1
where `id` = OLD.`workshop_id` and `nbparticipants` > 0;
end$$
delimiter ;