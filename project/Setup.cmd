@echo off
:ask
echo 'if you already installed the software any data will be erased'
set /p N="Do you wish to continue?(Y/N)"
If /i "%N%"=="Y" goto yes
If /i "%N%"=="N" goto no
goto ask
:yes
cls
cd ../MySQLScripts
color 0A
echo please enter your mysql root user password in order to create database users.Just hit ENTER if no password.
set /p pass="Enter Password:"
if "%pass%" == "" (
mysql -u root < users/create_admin.sql 2>nul
) else (
mysql -uroot -p%pass% < users/create_admin.sql 2>nul
)
mysql -uadmin -padmin < tables/database_tables.sql 2>nul > NUL
color 0A
echo Database fully created!
cd ../project/CrowdSourcing
php artisan migrate:fresh
php artisan config:clear
php artisan cache:clear
php artisan db:seed

cd ../../MySQLScripts

mysql -uadmin -padmin < users/create_users.sql 2>nul
echo created users...
mysql -uadmin -padmin < users/monitor_privileges.sql 2>nul
echo granted monitor permissions
mysql -uadmin -padmin < users/participant_privileges.sql 2>nul
echo granted participant permissions
:no
pause
exit