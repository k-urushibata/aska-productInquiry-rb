<?php
// データベース接続設定
class DatabaseConfig {
    const HOST = 'db'; // Docker Composeのサービス名
    const DBNAME = 'asukaelshop';
    const USER = 'root';
    const PASS = 'root';
    const CHARSET = 'utf8mb4';
    
    public static function getConnection() {
        try {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=" . self::CHARSET;
            $pdo = new PDO($dsn, self::USER, self::PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]);
            
            // 文字エンコーディングを確実に設定
            $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("SET CHARACTER SET utf8mb4");
            $pdo->exec("SET character_set_connection=utf8mb4");
            
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("データベース接続失敗: " . $e->getMessage());
        }
    }
}
?> 