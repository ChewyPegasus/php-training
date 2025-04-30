SELECT country FROM customers
INTERSECT
SELECT country FROM employees
INTERSECT
SELECT country FROM suppliers;
