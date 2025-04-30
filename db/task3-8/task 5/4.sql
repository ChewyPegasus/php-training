SELECT company_name, order_id
FROM customers
LEFT JOIN orders USING(customer_id)
WHERE order_id IS NULL