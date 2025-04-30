@echo off
echo DB creation

docker exec -i clickhouse-server clickhouse-client --query "CREATE DATABASE IF NOT EXISTS nyc_taxi;"

echo https://clickhouse.com/docs/getting-started/example-datasets/nyc-taxi

(
    echo CREATE TABLE IF NOT EXISTS nyc_taxi.trips_small (
        echo `trip_id`             UInt32,
        echo `pickup_datetime`     DateTime,
        echo `dropoff_datetime`    DateTime,
        echo `pickup_longitude`    Nullable^(Float64^),
        echo `pickup_latitude`     Nullable^(Float64^),
        echo `dropoff_longitude`   Nullable^(Float64^),
        echo `dropoff_latitude`    Nullable^(Float64^),
        echo `passenger_count`     UInt8,
        echo `trip_distance`       Float32,
        echo `fare_amount`         Float32,
        echo `extra`               Float32,
        echo `tip_amount`          Float32,
        echo `tolls_amount`        Float32,
        echo `total_amount`        Float32,
        echo `payment_type`        Enum^('CSH' = 1, 'CRE' = 2, 'NOC' = 3, 'DIS' = 4, 'UNK' = 5^),
        echo `pickup_ntaname`      LowCardinality^(String^),
        echo `dropoff_ntaname`     LowCardinality^(String^)
    echo ^)
    echo ENGINE = MergeTree
    echo PRIMARY KEY ^(pickup_datetime, dropoff_datetime^);
) > ../sql/create_table.sql

docker exec -i clickhouse-server clickhouse-client < ../sql/create_table.sql

echo Success!
pause