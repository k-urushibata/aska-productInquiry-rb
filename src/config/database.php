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
            $pdo = new PDO($dsn, self::USER, self::PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("データベース接続失敗: " . $e->getMessage());
        }
    }
}
?> 