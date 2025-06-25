-- 商品在庫管理システム 初期スキーマ定義
-- MySQLコンテナ起動時に自動実行される（初回のみ）

-- データベースの選択
USE asukaelshop;

DROP TABLE IF EXISTS t_stock;
DROP TABLE IF EXISTS m_product;

CREATE TABLE m_product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL COMMENT '商品名',
    product_code VARCHAR(100) NOT NULL UNIQUE COMMENT '商品コード',
    price DECIMAL(10,2) NOT NULL COMMENT '価格',
    manufacturer_name VARCHAR(255) NOT NULL COMMENT 'メーカー名',
    image_path VARCHAR(255) COMMENT '画像パス',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品マスタ';

CREATE TABLE t_stock (
    product_id INT NOT NULL PRIMARY KEY COMMENT '商品ID',
    quantity INT NOT NULL DEFAULT 0 COMMENT '在庫数量',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    FOREIGN KEY (product_id) REFERENCES m_product(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='在庫テーブル';

CREATE INDEX idx_product_code ON m_product(product_code);
CREATE INDEX idx_product_name ON m_product(product_name);
CREATE INDEX idx_manufacturer ON m_product(manufacturer_name); 