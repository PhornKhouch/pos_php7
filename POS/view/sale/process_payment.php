<?php
include ('../../Config/conect.php');
include '../sale/telegram_helper.php';
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. Only POST requests are allowed.');
    }

    // Get POST data
    $input = file_get_contents('php://input');
    if (empty($input)) {// input == null
        throw new Exception('No data received');
    }

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }

    // Validate required fields
    $requiredFields = ['invoice', 'saleDate', 'items', 'subtotal', 'tax', 'total', 'paymentMethod'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: {$field}");
        }
    }

    // Start transaction
    $con->begin_transaction();

    // Insert into sales master table
    $sql = "INSERT INTO salemaster (invoice, saledate, subtotal, tax, total, paymentmethod, createdon) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("ssddds", 
        $data['invoice'],
        $data['saleDate'],
        $data['subtotal'],
        $data['tax'],
        $data['total'],
        $data['paymentMethod']
    );

    if (!$stmt->execute()) {
        throw new Exception("Error inserting sale master: " . $stmt->error);
    }
    
    $saleId = $con->insert_id;

    // Insert sale details
    $detailSql = "INSERT INTO saledetail (saleid, productid, quantity, price, total) VALUES (?, ?, ?, ?, ?)";
    $detailStmt = $con->prepare($detailSql);
    if (!$detailStmt) {
        throw new Exception("Prepare failed for detail: " . $con->error);
    }

    $ID;
    foreach ($data['items'] as $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $ID= $item['id'];
        if (!$detailStmt->bind_param("iiddd", 
            $saleId,
            $item['id'],
            $item['quantity'],
            $item['price'],
            $itemTotal
        )) {
            throw new Exception("Binding parameters failed: " . $detailStmt->error);
        }

        if (!$detailStmt->execute()) {
            throw new Exception("Error inserting sale detail: " . $detailStmt->error);
        }

        // Update stock quantity
        $updateStock = "UPDATE prdmaster SET stockqty = stockqty - ? WHERE id = ?";
        $stockStmt = $con->prepare($updateStock);
        if (!$stockStmt) {
            throw new Exception("Prepare failed for stock update: " . $con->error);
        }

        if (!$stockStmt->bind_param("di", $item['quantity'], $item['id'])) {
            throw new Exception("Binding parameters failed for stock update: " . $stockStmt->error);
        }

        if (!$stockStmt->execute()) {
            throw new Exception("Error updating stock: " . $stockStmt->error);
        }
    }

    // Commit transaction
    $con->commit();
    //alert to Telegram
    //

    $selectPRD= "SELECT * FROM prdmaster WHERE id = '$ID'";
    $resultPRD = $con->query($selectPRD);
    $rowPRD = $resultPRD->fetch_assoc();
    $grpID=$rowPRD['telegram_group'];//ID group


    $selectToken= "SELECT * FROM telegram where groupid = '$grpID'";
    $resultToken = $con->query($selectToken);
    $rowToken = $resultToken->fetch_assoc();
    $token=$rowToken["token"];//token
    

    $message = formatPaymentMessage(
        $data['saleDate'],
        $item['price'],
        $data['tax'],
        $data['paymentMethod'],
        "Paid",
        $data['invoice'],
        $item['quantity']
    );
    
    if($rowToken["IsAlert"]==1){
        sendTelegramMessage($message,$token,$grpID);
    }
   

    echo json_encode([
        'success' => true,
        'message' => 'Sale completed successfully',
        'saleId' => $saleId,
        'invoice' => $data['invoice']
    ]);



} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($con) && $con->connect_errno === 0) {
        $con->rollback();
    }
    
    error_log("Payment processing error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error processing sale: ' . $e->getMessage()
    ]);
} finally {
    if (isset($con) && $con->connect_errno === 0) {
        $con->close();
    }
}
?>
