@echo off
cd /d "%~dp0"
start /B "" "php\php.exe" -c "php\php.ini" -S localhost:8000 -t . router.php
timeout /t 2 >nul
start vivaldi "http://localhost:8000/GS/index.php"
pause
taskkill /F /IM php.exe 2>nul