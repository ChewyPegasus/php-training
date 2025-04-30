@echo off
echo Installing Clickhouse
mkdir ..\clickhouse-data 2>nul

docker stop clickhouse-server
docker rm clickhouse-server

echo Docker container
docker run -d ^
        --name clickhouse-server ^
        -p 8123:8123 ^
        -p 9000:9000 ^
        --ulimit nofile=262144:262144 ^
        -v clickhouse-vol:/var/lib/clickhouse ^
        -e CLICKHOUSE_USER=default ^
        -e CLICKHOUSE_PASSWORD=password ^
        -e CLICKHOUSE_DB=default ^
        clickhouse/clickhouse-server

timeout /t 10 /nobreak > NUL

echo Connected!
curl -s "http://localhost:8123/ping"
pause