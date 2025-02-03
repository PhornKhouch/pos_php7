<?php
session_start();
require_once '../../Config/conect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: ../../view/Login/login.php?error=1');
        exit;
    }

    try {
        // Prepare the SQL query using mysqli
        $stmt = $con->prepare('SELECT id, username, password, full_name, role FROM users WHERE username = ? AND password = ?');
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            if($user['date_exp']<date('Y-m-d')){
                header('Location: ../../view/Login/login.php?error=1');
                exit;
            }
            else{
                header('Location: ../../index.php');
                exit;
            }
        } else {
            header('Location: ../../view/Login/login.php?error=1');
            exit;
        }
    } catch (Exception $e) {
        // Log error securely
        error_log("Login error: " . $e->getMessage());
        header('Location: ../../view/Login/login.php?error=1');
        exit;
    }
} else {
    header('Location: ../../view/Login/login.php');
    exit;
}
