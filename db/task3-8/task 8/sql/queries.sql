EXPLAIN ANALYZE
SELECT * FROM products WHERE unit_price BETWEEN 10 AND 20;

EXPLAIN ANALYZE
SELECT * FROM products WHERE product_name LIKE 'A%';

EXPLAIN ANALYZE
SELECT * FROM products WHERE supplier_id = 5 AND category_id = 3;

