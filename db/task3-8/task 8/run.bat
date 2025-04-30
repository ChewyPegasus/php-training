@echo off

IF NOT EXIST php\run.php (
  echo Error: File php\run.php is not found!
  goto :end
)

echo === Step 1: Table Creation ===
php "php/run.php" "sql/create.sql"
echo.

echo === Step 2: Data generation ===
php "php/generate.php"
echo.

echo === Step 3: Run queries (with no indexes) ===
php "php/run.php" "sql/queries.sql"
echo.

echo === Step 4: Index Creation ===
php "php/run.php" "sql/indexes.sql"
echo.

echo === Step 5: Run queries (with indexes) ===
php "php/run.php" "sql/queries.sql"
echo.

echo Hooray success ura pobeda!

:end
pause