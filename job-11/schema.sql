-- Schema for child tables using product_id as primary key and foreign key
CREATE TABLE IF NOT EXISTS clothing (
    product_id INT PRIMARY KEY,
    size VARCHAR(50) DEFAULT '',
    color VARCHAR(50) DEFAULT '',
    type VARCHAR(100) DEFAULT '',
    material_fee INT DEFAULT 0,
    CONSTRAINT fk_clothing_product FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS electronic (
    product_id INT PRIMARY KEY,
    brand VARCHAR(100) DEFAULT '',
    waranty_fee INT DEFAULT 0,
    CONSTRAINT fk_electronic_product FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);
