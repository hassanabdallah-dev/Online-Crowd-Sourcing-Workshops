drop user if exists participant;
drop user if exists monitor;
create user if not exists participant identified WITH mysql_native_password by 'participant';
create user if not exists monitor identified WITH mysql_native_password by 'monitor';
