<?php
require_once __DIR__ . '/../config/mail.php';
require_once '/var/www/html/vendor/autoload.php'; // PHPMailerのautoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class InquiryController {
    
    /**
     * 問い合わせメールを送信
     */
    public function sendInquiry($data) {
        try {
            // 入力データの検証
            $this->validateInquiryData($data);
            
            // メール内容を生成
            $mailContent = $this->generateMailContent($data);
            
            // PHPMailerで送信
            $mail = new PHPMailer(true);
            $smtp = MailConfig::getSmtpConfig();
            $fromInfo = MailConfig::getFromInfo();

            $mail->isSMTP();
            $mail->Host = $smtp['host'];
            $mail->Port = $smtp['port'];
            $mail->SMTPAuth = false;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($fromInfo['email'], $fromInfo['name']);
            $mail->addAddress(MailConfig::getAdminEmail());
            $mail->addReplyTo($data['customer_email'], $data['customer_name']);
            $mail->Subject = MailConfig::generateSubject($data['product_name']);
            $mail->Body = $mailContent;

            $mail->send();
            
            return [
                'success' => true,
                'message' => '問い合わせを送信しました。管理者からの返信をお待ちください。'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'メール送信に失敗しました: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * 入力データの検証
     */
    private function validateInquiryData($data) {
        $required = ['customer_name', 'customer_email', 'customer_phone', 'inquiry_content', 'product_name'];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("必須項目「{$field}」が入力されていません。");
            }
        }
        
        // メールアドレスの形式チェック
        if (!filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('正しいメールアドレスを入力してください。');
        }
        
        // 電話番号の形式チェック（簡易）
        if (!preg_match('/^[0-9\-\(\)\s]+$/', $data['customer_phone'])) {
            throw new Exception('正しい電話番号を入力してください。');
        }
    }
    
    /**
     * メール内容を生成
     */
    private function generateMailContent($data) {
        $fromInfo = MailConfig::getFromInfo();
        
        $content = "商品問い合わせが届きました。\n\n";
        $content .= "【商品情報】\n";
        $content .= "商品名: " . $data['product_name'] . "\n";
        if (!empty($data['product_code'])) {
            $content .= "商品コード: " . $data['product_code'] . "\n";
        }
        if (!empty($data['manufacturer_name'])) {
            $content .= "メーカー: " . $data['manufacturer_name'] . "\n";
        }
        if (!empty($data['price'])) {
            $content .= "価格: " . $data['price'] . " 円\n";
        }
        if (!empty($data['quantity'])) {
            $content .= "在庫数: " . $data['quantity'] . "\n";
        }
        
        $content .= "\n【お客様情報】\n";
        $content .= "お名前: " . $data['customer_name'] . "\n";
        $content .= "メールアドレス: " . $data['customer_email'] . "\n";
        $content .= "電話番号: " . $data['customer_phone'] . "\n";
        
        $content .= "\n【問い合わせ内容】\n";
        $content .= $data['inquiry_content'] . "\n\n";
        
        $content .= "---\n";
        $content .= "このメールは商品在庫管理システムから自動送信されました。\n";
        $content .= "返信の際は、お客様のメールアドレス（" . $data['customer_email'] . "）宛にお送りください。\n";
        
        return $content;
    }
    
    /**
     * 商品情報を取得
     */
    public function getProductInfo($productCode) {
        try {
            require_once __DIR__ . '/../config/database.php';
            $pdo = DatabaseConfig::getConnection();
            
            $sql = "SELECT p.*, s.quantity 
                    FROM m_product p 
                    LEFT JOIN t_stock s ON p.id = s.product_id 
                    WHERE p.product_code = :product_code";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['product_code' => $productCode]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            return null;
        }
    }
}
?> 