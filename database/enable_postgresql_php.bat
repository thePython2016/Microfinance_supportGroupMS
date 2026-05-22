@echo off
setlocal
echo Fixing PostgreSQL support for XAMPP Apache...
echo.

set XAMPP=C:\xampp
if not exist "%XAMPP%\php\php.ini" (
    echo ERROR: XAMPP not found at %XAMPP%
    pause
    exit /b 1
)

copy /Y "%XAMPP%\php\libpq.dll" "%XAMPP%\apache\bin\libpq.dll"
copy /Y "%XAMPP%\php\php.ini" "%XAMPP%\apache\bin\php.ini"

powershell -NoProfile -Command ^
  "$ini = '%XAMPP%\apache\bin\php.ini';" ^
  "$c = Get-Content $ini -Raw;" ^
  "$c = $c -replace ';extension=pdo_pgsql','extension=pdo_pgsql';" ^
  "$c = $c -replace ';extension=pgsql','extension=pgsql';" ^
  "if ($c -notmatch 'extension=pdo_pgsql') { $c += \"`r`nextension=pdo_pgsql`r`n\" };" ^
  "if ($c -notmatch 'extension_dir') { $c = 'extension_dir=\"%XAMPP:\=\\%\\php\\ext\"' + \"`r`n\" + $c };" ^
  "Set-Content $ini $c -NoNewline"

echo.
echo Apache php.ini: %XAMPP%\apache\bin\php.ini
echo libpq.dll copied to apache\bin
echo.
echo IMPORTANT: Open the app only via XAMPP Apache:
echo   http://localhost/finance/
echo.
echo Restart Apache in XAMPP Control Panel now.
pause
