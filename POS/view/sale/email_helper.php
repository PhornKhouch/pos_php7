<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function sendSaleEmail($invoice, $saleDate, $items, $subtotal, $tax, $total, $paymentMethod) {
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pkhouch97@gmail.com'; 
        $mail->Password   = 'rjqo zjyn amuh ncbx'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPDebug  = 0; 
        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';

        // Recipients
        $mail->setFrom('pkhouch97@gmail.com', 'POS System');
        $mail->addAddress('sokkimheng505@gmail.com'); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Sale - Invoice #$invoice";

        // Create email body
        $body = "<h2>Sale Details</h2>";
        $body .= "<p><strong>Invoice:</strong> $invoice</p>";
        $body .= "<p><strong>Date:</strong> $saleDate</p>";
        $body .= "<p><strong>Payment Method:</strong> $paymentMethod</p>";
        
        $body .= "<h3>Items:</h3>";
        $body .= "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        $body .= "<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
        
        foreach ($items as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $body .= "<tr>";
            $body .= "<td>{$item['name']}</td>";
            $body .= "<td>{$item['quantity']}</td>";
            $body .= "<td>\${$item['price']}</td>";
            $body .= "<td>\${$itemTotal}</td>";
            $body .= "</tr>";
        }
        
        $body .= "</table>";
        $body .= "<p><strong>Subtotal:</strong> \$$subtotal</p>";
        $body .= "<p><strong>Tax:</strong> \$$tax</p>";
        $body .= "<p><strong>Total:</strong> \$$total</p>";

        $mail->Body = $body;
        $mail->AltBody = strip_tags(str_replace(['<tr>', '</tr>', '</td>'], ["\n", '', ', '], $body));

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}
?>
