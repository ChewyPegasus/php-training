DROP TABLE IF EXISTS products CASCADE;

CREATE TABLE products (
    product_id int PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    product_name VARCHAR(100) NOT NULL,
    supplier_id int NOT NULL,
    category_id int NOT NULL,
    quantity_per_unit VARCHAR(50) NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    units_in_stock int DEFAULT 0,
    units_on_order int DEFAULT 0,
    reorder_level int DEFAULT 0,
    discontinued BOOLEAN DEFAULT false,
    rating smallint DEFAULT 0,
    creation_date timestamp DEFAULT CURRENT_TIMESTAMP
);