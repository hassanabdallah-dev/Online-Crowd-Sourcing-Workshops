@echo off
color 0A
mysql -uadmin -padmin < users/create_users.sql 2>nul
mysql -uadmin -padmin < users/monitor_privileges.sql 2>nul
mysql -uadmin -padmin < users/participant_privileges.sql 2>nul
pause
