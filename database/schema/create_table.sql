-- 商品マスタテーブル
DROP TABLE IF EXISTS t_stock;
DROP TABLE IF EXISTS m_product;
CREATE TABLE m_product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    product_code VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    manufacturer_name VARCHAR(255) NOT NULL,
    image_path VARCHAR(255)
);

-- 在庫テーブル
CREATE TABLE t_stock (
    product_id INT NOT NULL PRIMARY KEY,
    quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES m_product(id)
);

-- 初期データの挿入
INSERT INTO m_product (product_name, product_code, price, manufacturer_name, image_path) VALUES
('りんご', 'AP001', 100.00, '青果', NULL),
('バナナ', 'BN002', 80.00, '青果', NULL),
('みかん', 'OR003', 120.00, '青果', NULL),
('トマト', 'TM004', 150.00, '青果', NULL),
('キャベツ', 'CB005', 200.00, '青果', NULL);

-- 在庫データの挿入
INSERT INTO t_stock (product_id, quantity) VALUES
(1, 50),
(2, 30),
(3, 25),
(4, 40),
(5, 15);
