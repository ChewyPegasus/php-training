SELECT product_name, units_in_stock
FROM products
WHERE units_in_stock < (
	SELECT MIN(avg_q) FROM (
		SELECT AVG(quantity) AS avg_q
		FROM order_details
		GROUP BY product_id
	)
);