SELECT customer_id, SUM(freight) as total_sum
FROM orders
WHERE freight >= (SELECT AVG(freight) FROM orders)
		AND shipped_date BETWEEN '1996-07-16' AND '1996-07-31'
GROUP BY customer_id
ORDER BY total_sum;