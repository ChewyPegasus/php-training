SELECT product_name, units_in_stock, contact_name, phone
FROM products
INNER JOIN categories USING(category_id)
INNER JOIN suppliers USING(supplier_id)
WHERE discontinued != 1 AND units_in_stock < 20
AND category_name IN ('Beverages', 'Seafood')