REM @echo off
REM cd /d "%~dp0"
REM start /B "" "php\php.exe" -c "php\php.ini" -S localhost:8000 -t .
REM timeout /t 2 >nul
REM start chrome "http://localhost:8000/GS/index.html"
REM pause
REM taskkill /F /IM php.exe 2>nul

@echo off
cd /d "%~dp0"
start /B "" "php\php.exe" -c "php\php.ini" -S localhost:8000 -t .
timeout /t 2 >nul

where chrome >nul 2>nul
if %errorlevel% equ 0 (
    start chrome "http://localhost:8000/GS/index.html"
    goto :wait
)

where msedge >nul 2>nul
if %errorlevel% equ 0 (
    start msedge "http://localhost:8000/GS/index.html"
    goto :wait
)

start "http://localhost:8000/GS/index.html"

:wait
pause
taskkill /F /IM php.exe 2>nul
