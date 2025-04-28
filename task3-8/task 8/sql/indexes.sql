CREATE INDEX idx_btree_unit_price ON products USING btree(unit_price);

CREATE INDEX idx_hash_product_name ON products USING hash(product_name);

CREATE INDEX idx_composite_supplier_category ON products (supplier_id, category_id);