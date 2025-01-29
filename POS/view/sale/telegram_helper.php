<?php
//send to telegram
function sendTelegramMessage($message) {
    $botToken = '7542013952:AAEmeHVHzBS-ir_eMhgBfE_dPN_9oJ9cy28'; // Telegram bot token
    $chatId = '-1002455165520';     //  group chat ID
    
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    return $result;
}

//message
function formatPaymentMessage($PayDate, $amount, $VAT, $paymentMethod, $paymentStatus,$invoiceNo,$quantity) {
    $message = "<b>----Payment Receipt----</b>\n\n";
    $message .= "<b>InvoiceNo:</b> {$invoiceNo}\n";
    $message .= "<b>PayDate:</b> {$PayDate}\n";
    $message .= "<b>Amount:</b> {$amount}$\n";
    $message .= "<b>VAT:</b>{$VAT}$\n";
    $message .= "<b>PayMethod:</b> {$paymentMethod}\n";
    $message .= "<b>Quantity:</b> {$quantity}\n";
    $message .= "<b>Status:</b> {$paymentStatus}\n";
    
    return $message;
}

