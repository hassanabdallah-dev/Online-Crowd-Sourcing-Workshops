drop view if exists monitorhistory;
create view monitorhistory as 
	select `monitor_id`, `nbparticipants`, `name`, `location`, `workshop`.`created_at`
        from `workshop`;