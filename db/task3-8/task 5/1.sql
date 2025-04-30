SELECT customers.company_name, first_name || ' ' || last_name AS full_name
FROM orders
INNER JOIN customers USING(customer_id)
INNER JOIN employees USING(employee_id)
INNER JOIN shippers ON ship_via = shipper_id
WHERE customers.city = 'London' 
	AND employees.city = 'London'
	AND shippers.company_name = 'Speedy Express';