@echo off
echo Checking for updates...

cd /d "C:\xampp\htdocs\allure"
git pull

echo Update complete!
pause

@echo off
echo ================================
echo Updating Allure Application...
echo ================================

REM Go to project directory
cd /d C:\xampp\htdocs\allure

REM Pull latest changes
echo Pulling latest code from Git...
git pull origin main

IF %ERRORLEVEL% NEQ 0 (
    echo Git pull failed. Aborting.
    pause
    exit /b
)

REM Run Laravel migrations
echo Running database migrations...
php artisan migrate

IF %ERRORLEVEL% NEQ 0 (
    echo Migration failed.
    pause
    exit /b
)

echo ================================
echo Update completed successfully!
echo ================================
pause
