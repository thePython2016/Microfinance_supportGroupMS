@echo off
echo Enabling PostgreSQL support for XAMPP Apache...
copy /Y "C:\xampp\php\libpq.dll" "C:\xampp\apache\bin\libpq.dll"
echo.
echo Done. Restart Apache from the XAMPP Control Panel, then open:
echo http://localhost/finance/database/check_php.php
pause
