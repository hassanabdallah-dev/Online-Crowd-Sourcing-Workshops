drop user if exists 'admin';
create user if not exists monitor identified WITH mysql_native_password by 'admin';
grant all privileges on *.* to 'admin'@'localhost' with grant option