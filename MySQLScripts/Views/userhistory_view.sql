drop view if exists userhistory;
create view userhistory as
	select `participant_id`, `name`, `location`, `workshop`.`created_at`
        from `workshop`, `participant_workshop`
        where `id` = `workshop_id`;