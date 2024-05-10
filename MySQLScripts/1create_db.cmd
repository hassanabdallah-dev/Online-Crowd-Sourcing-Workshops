@echo off
echo please enter your mysql root user password in order to create database users.Just hit ENTER if no password.
set /p pass="Enter Password:"
if "%pass%" == "" (
mysql -u root < users/create_admin.sql 2>nul
) else (
mysql -uroot -p%pass% < users/create_admin.sql 2>nul
)
pause

mysql -uadmin -padmin < tables/database_tables.sql 2>nul
color 0A
echo Database fully created!
cd ../project/CrowdSourcing
php artisan migrate:fresh
php artisan config:clear
php artisan cache:clear
php artisan db:seed
pause