SELECT order_id, customer_id, ship_country, SUM(unit_price * quantity * (1 - discount)) AS order_price
FROM orders
INNER JOIN order_details USING(order_id)
WHERE order_date >= '1997-09-01'
		AND ship_country IN ('Argentina', 'Bolivia', 'Brazil', 'Chile', 'Colombia', 
	                       'Ecuador', 'Guyana', 'Paraguay', 'Peru', 
	                       'Suriname', 'Uruguay', 'Venezuela')
GROUP BY order_id, customer_id, ship_country
ORDER BY order_price DESC
LIMIT 3;