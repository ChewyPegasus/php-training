SELECT DISTINCT product_name
FROM products
INNER JOIN order_details USING(product_id)
WHERE quantity = 10;

--два возможных понимания: "в одном заказе ровно 10" или "всего за все время ровно 10

SELECT product_name
FROM products
INNER JOIN order_details USING(product_id)
GROUP BY product_name
HAVING SUM(quantity) = 10;