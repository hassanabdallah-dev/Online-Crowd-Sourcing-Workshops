drop trigger if exists insert_users_group;
delimiter $$
create trigger insert_users_group before insert on `users_group` 
for each row
begin
declare exceeded int;
select exists(select null from `group` where `id` = NEW.`group_id` and `full` = 1) into exceeded;
if exceeded = 1 then
signal sqlstate '40002' set message_text ='cannot insert participant in a full group';
else
update `group` 
set `nbParticipants` = `nbParticipants` + 1
where `id` = NEW.`group_id`;
end if;
end$$
delimiter ;