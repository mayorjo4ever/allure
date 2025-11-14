@echo off
cd /d C:\xampp8.2\htdocs\allure
C:\xampp8.2\php\php.exe artisan queue:work
pause