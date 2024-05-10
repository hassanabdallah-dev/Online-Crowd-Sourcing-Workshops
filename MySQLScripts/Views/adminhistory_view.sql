drop view if exists adminhistory;
create view adminhistory as 
	select `users`.`name` as `monitor`,  `nbparticipants`, `workshop`.`name`, `location`, `workshop`.`created_at`
        from `workshop`,`users`
        where `monitor_id` = `users`.`id`;