<?php
// メール送信設定
class MailConfig {
    // 管理者メールアドレス
    const ADMIN_EMAIL = 'admin@example.com';
    
    // メール送信者名
    const FROM_NAME = '商品在庫管理システム';
    
    // メール送信者アドレス
    const FROM_EMAIL = 'noreply@example.com';
    
    // メール件名のプレフィックス
    const SUBJECT_PREFIX = '[商品問い合わせ]';
    
    // Docker環境でのSMTP設定
    const SMTP_HOST = 'mailhog';  // Docker Composeのサービス名
    const SMTP_PORT = 1025;
    
    /**
     * 管理者メールアドレスを取得
     */
    public static function getAdminEmail() {
        return self::ADMIN_EMAIL;
    }
    
    /**
     * 送信者情報を取得
     */
    public static function getFromInfo() {
        return [
            'name' => self::FROM_NAME,
            'email' => self::FROM_EMAIL
        ];
    }
    
    /**
     * メール件名を生成
     */
    public static function generateSubject($productName = '') {
        $subject = self::SUBJECT_PREFIX;
        if (!empty($productName)) {
            $subject .= ' ' . $productName;
        }
        return $subject;
    }
    
    /**
     * SMTP設定を取得
     */
    public static function getSmtpConfig() {
        return [
            'host' => self::SMTP_HOST,
            'port' => self::SMTP_PORT
        ];
    }
}
?> 