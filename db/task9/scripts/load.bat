@echo off
echo Loading test data

if not exist "%cd%\..\downloads" (
    echo Create downloads directory...
    mkdir "%cd%\..\downloads"
)

FOR /L %%A IN (1,1,2) DO (
    echo.
    echo Downloading chunk %%A of 2...
    curl -s https://storage.googleapis.com/clickhouse-public-datasets/nyc-taxi/trips_%%A.gz -o "%cd%\..\downloads\trips_%%A.tsv.gz"
    
    echo Copy chunk %%A to container...
    docker cp "%cd%\..\downloads\trips_%%A.tsv.gz" clickhouse-server:/tmp/
    
    echo Extracting and loading chunk %%A...
    docker exec -i clickhouse-server bash -c "gunzip -f /tmp/trips_%%A.tsv.gz && clickhouse-client --query=\"INSERT INTO nyc_taxi.trips_small FORMAT TSV\" < /tmp/trips_%%A.tsv"
    
    echo Chunk %%A loaded successfully.
)

echo.
echo All data loaded! Count records:
docker exec -i clickhouse-server clickhouse-client --query="SELECT count(*) FROM nyc_taxi.trips_small;"

echo.
echo Load complete!
pause