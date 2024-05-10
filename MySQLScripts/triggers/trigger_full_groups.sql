use crowdcrowd;
drop trigger if exists trigger_full_groups;
delimiter $$
create trigger trigger_full_groups before update on `group`
for each row
begin
if NEW.nbParticipants <> OLD.nbParticipants then
if NEW.nbParticipants = NEW.nbParticipantsmax then
set NEW.`full` = 1;
end if;
if OLD.`full` = 1 and NEW.nbParticipants < NEW.nbParticipantsmax then
set NEW.`full` = 0;
end if;
end if;
end$$
delimiter ;