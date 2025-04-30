@echo off

echo User's input to query

if not exist "%cd%\..\sql\custom" (
    echo Creating directory for storing SQL queries...
    mkdir "%cd%\..\sql\custom"
)

for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YYYY=%dt:~0,4%"
set "MM=%dt:~4,2%"
set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%"
set "Min=%dt:~10,2%"
set "Sec=%dt:~12,2%"
set "timestamp=%YYYY%%MM%%DD%_%HH%%Min%%Sec%"

set /p query="Enter your SQL query: "

set "sql_file=%cd%\..\sql\custom\query_%timestamp%.sql"
echo !query!>"%sql_file%"

docker exec -i clickhouse-server clickhouse-client --query="%query%"

echo Success!
pause