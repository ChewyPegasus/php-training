DROP TABLE IF EXISTS regions CASCADE;
DROP TABLE IF EXISTS factories CASCADE;
DROP TABLE IF EXISTS machines CASCADE;
DROP TABLE IF EXISTS dates CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS weeklyFixCost CASCADE;
DROP TABLE IF EXISTS weeklyPackagingCost CASCADE;
DROP TABLE IF EXISTS orderItems CASCADE;
DROP TABLE IF EXISTS orders CASCADE;
DROP TABLE IF EXISTS delieveryCost CASCADE;

DROP TYPE IF EXISTS DaysOfWeek CASCADE;
DROP TYPE IF EXISTS TypesOfOrder CASCADE;
DROP TYPE IF EXISTS OrderMeasuringUnits CASCADE;
DROP TYPE IF EXISTS Currency CASCADE;


CREATE TABLE regions (
	id int NOT NULL,
	name varchar(255)
);

CREATE TABLE factories (
	id int NOT NULL,
	region_id int NOT NULL,
	name varchar(255)
);

CREATE TABLE machines (
	id int NOT NULL,
	factory_id int NOT NULL,
	name varchar(255)
);

CREATE TABLE products (
	id int NOT NULL,
	item_id int NOT NULL,
	machine_id int NOT NULL,
	factory_id int NOT NULL,
	name varchar(255),
	packaging_id int NOT NULL
);

CREATE TYPE DaysOfWeek AS ENUM ('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');

CREATE TABLE dates (
	id int NOT NULL,
	day DaysOfWeek,
	week smallint,
	month smallint,
	quarter smallint,
	year int
);

CREATE TABLE orders (
	id int NOT NULL,
	factory_id int NOT NULL,
	date_id int NOT NULL
);

CREATE TYPE TypesOfOrder AS enum ('market', 'limit', 'gtc', 'stop-loss');
CREATE TYPE OrderMeasuringUnits AS enum ('m', 'kg', 'l', 'sqm', 's', 'oC');

CREATE TABLE orderItems (
	id int NOT NULL,
	item_id int NOT NULL,
	order_id int NOT NULL,
	date date,
	type TypesOfOrder,
	quantity int,
	unitMeasure OrderMeasuringUnits,
	pricePerUnite decimal(10, 2),
	costPerUnite decimal(10, 2),
	totalAmount int
);

CREATE TABLE delieveryCost (
	id int NOT NULL,
	order_id int NOT NULL,
	quantity int,
	pricePerUnit decimal(10, 2),
	totalAmount int
);

CREATE TYPE Currency AS enum ('$', '€', '¥', '£');

CREATE TABLE weeklyPackagingCost (
	id int NOT NULL,
	date_id int NOT NULL,
	product_id int NOT NULL,
	packagingItem varchar(255),
	unitMeasure Currency,
	totalAmount int
);

CREATE TABLE weeklyFixCost (
	id int NOT NULL,
	machine_id int NOT NULL,
	date_id int NOT NULL,
	fixCostDescription text,
	totalAmount int,
	region_id int NOT NULL
);


ALTER TABLE ONLY regions 
	ADD CONSTRAINT pk_regions PRIMARY KEY (id);

ALTER TABLE ONLY factories 
	ADD CONSTRAINT pk_factories PRIMARY KEY (id);

ALTER TABLE ONLY machines 
	ADD CONSTRAINT pk_machines PRIMARY KEY (id);

ALTER TABLE ONLY dates 
	ADD CONSTRAINT pk_dates PRIMARY KEY (id);

ALTER TABLE ONLY products 
	ADD CONSTRAINT pk_products PRIMARY KEY (id);

ALTER TABLE ONLY weeklyFixCost 
	ADD CONSTRAINT pk_weeklyFixCost PRIMARY KEY (id);

ALTER TABLE ONLY weeklyPackagingCost 
	ADD CONSTRAINT pk_weeklyPackagingCost PRIMARY KEY (id);

ALTER TABLE ONLY orderItems 
	ADD CONSTRAINT pk_orderItems PRIMARY KEY (id);

ALTER TABLE ONLY delieveryCost 
	ADD CONSTRAINT pk_delieveryCost PRIMARY KEY (id);

ALTER TABLE ONLY orders 
	ADD CONSTRAINT pk_orders PRIMARY KEY (id);


ALTER TABLE ONLY factories
	ADD CONSTRAINT fk_factories_regions FOREIGN KEY (region_id) REFERENCES regions;

ALTER TABLE ONLY machines
	ADD CONSTRAINT fk_machines_factories FOREIGN KEY (factory_id) REFERENCES factories;

ALTER TABLE products
	ADD CONSTRAINT fk_products_factories FOREIGN KEY (factory_id) REFERENCES factories,
	ADD CONSTRAINT fk_products_machines FOREIGN KEY (machine_id) REFERENCES machines;

ALTER TABLE orders
	ADD CONSTRAINT fk_orders_factories FOREIGN KEY (factory_id) REFERENCES factories,
	ADD CONSTRAINT fk_orders_dates FOREIGN KEY (date_id) REFERENCES dates;

ALTER TABLE delieveryCost
	ADD CONSTRAINT fk_delieveryCost_orders FOREIGN KEY (order_id) REFERENCES orders;

ALTER TABLE orderItems
	ADD CONSTRAINT fk_orderItems_orders FOREIGN KEY (order_id) REFERENCES orders,
	ADD CONSTRAINT fk_orderItems_products FOREIGN KEY (item_id) REFERENCES products;

ALTER TABLE weeklyPackagingCost
	ADD CONSTRAINT fk_weeklyPackagingCost_products FOREIGN KEY (product_id) REFERENCES products,
	ADD CONSTRAINT fk_weeklyPackagingCost_dates FOREIGN KEY (date_id) REFERENCES dates;

ALTER TABLE weeklyFixCost
	ADD CONSTRAINT fk_weeklyFixCost_regions FOREIGN KEY (region_id) REFERENCES regions,
	ADD CONSTRAINT fk_weeklyFixCost_machines FOREIGN KEY (machine_id) REFERENCES machines,
	ADD CONSTRAINT fk_weeklyFixCost_dates FOREIGN KEY (date_id) REFERENCES dates;
