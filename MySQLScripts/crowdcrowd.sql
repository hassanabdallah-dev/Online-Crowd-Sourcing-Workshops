DROP DATABASE IF EXISTS `crowdcrowd`
CREATE DATABASE `crowdcrowd` ;
USE `crowdcrowd`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
);
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
);
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `workshop`;
CREATE TABLE `workshop` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `nbparticipantsmax` int(11) NOT NULL,
  `nbparticipants` int(11) NOT NULL DEFAULT '0',
  `monitor_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_key_index` (`key`)
);
DROP TABLE IF EXISTS `participant_workshop`;
CREATE TABLE `participant_workshop` (
  `participant_id` bigint(20) unsigned NOT NULL,
  `workshop_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `participant_workshop_participant_id_index` (`participant_id`),
  KEY `participant_workshop_workshop_id_index` (`workshop_id`),
  CONSTRAINT `participant_workshop_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `participant_workshop_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `ideas`;
CREATE TABLE `ideas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(11) NOT NULL,
  `workshop_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `voted` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL,
  `taken` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);
DROP TABLE IF EXISTS `idea_participant`;
CREATE TABLE `idea_participant` (
  `participants_id` bigint(20) unsigned NOT NULL,
  `idea_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `idea_participant_participants_id_index` (`participants_id`),
  KEY `idea_participant_idea_id_index` (`idea_id`),
  CONSTRAINT `idea_participant_idea_id_foreign` FOREIGN KEY (`idea_id`) REFERENCES `ideas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `idea_participant_participants_id_foreign` FOREIGN KEY (`participants_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `participant_idea_original`;
CREATE TABLE `participant_idea_original` (
  `id_participant` bigint(20) unsigned NOT NULL,
  `id_idea` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `participant_idea_original_id_participant_index` (`id_participant`),
  KEY `participant_idea_original_id_idea_index` (`id_idea`),
  CONSTRAINT `participant_idea_original_id_idea_foreign` FOREIGN KEY (`id_idea`) REFERENCES `ideas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `participant_idea_original_id_participant_foreign` FOREIGN KEY (`id_participant`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idea_id` bigint(20) unsigned NOT NULL,
  `monitor_id` bigint(20) unsigned NOT NULL,
  `workshop_id` bigint(20) unsigned NOT NULL,
  `nbParticipants` bigint(20) unsigned NOT NULL,
  `nbParticipantsmax` bigint(20) unsigned NOT NULL,
  `full` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `users_group`;
CREATE TABLE `users_group` (
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `users_group_user_id_index` (`user_id`),
  KEY `users_group_group_id_index` (`group_id`),
  CONSTRAINT `users_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_group_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `preferences`;
CREATE TABLE `preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripton` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `preferences_id_unique` (`id`),
  UNIQUE KEY `preferences_name_unique` (`name`)
);
drop procedure if exists procedure_insert_groups;
delimiter $$
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
end$$
delimiter ;
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

drop view if exists userhistory;
create view userhistory as
	select `participant_id`, `name`, `location`, `workshop`.`created_at`
        from `workshop`, `participant_workshop`
        where `id` = `workshop_id`;
drop view if exists monitorhistory;
create view monitorhistory as 
	select `monitor_id`, `nbparticipants`, `name`, `location`, `workshop`.`created_at`
        from `workshop`;
drop view if exists adminhistory;
create view adminhistory as 
	select `users`.`name` as `monitor`,  `nbparticipants`, `workshop`.`name`, `location`, `workshop`.`created_at`
        from `workshop`,`users`
        where `monitor_id` = `users`.`id`;