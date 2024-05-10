drop trigger if exists delete_users_group;
delimiter $$
create trigger delete_users_group after delete on `users_group` 
for each row
begin
update `group` 
set `nbParticipants` = `nbParticipants` - 1
where `id` = OLD.`group_id` and `nbParticipants` > 0;
end$$
delimiter ;
