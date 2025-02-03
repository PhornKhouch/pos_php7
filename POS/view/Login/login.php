<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>POS System Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #00416A, #E4E5E6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Battambang', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, #3498db, #2980b9);
        }
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header h2 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .login-header p {
            color: #7f8c8d;
            font-size: 16px;
        }
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 42px;
            transform: translateY(-50%);
            color: #95a5a6;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .form-control {
            height: 50px;
            padding-left: 45px;
            font-size: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.1);
        }
        .form-control:focus + i {
            color: #3498db;
        }
        .form-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-login {
            height: 50px;
            font-size: 16px;
            font-weight: 600;
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 10px;
            color: white;
            width: 100%;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            background: linear-gradient(135deg, #2980b9, #3498db);
        }
        .btn-login i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }
        .btn-login:hover i {
            transform: translateX(5px);
        }
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border: none;
            background: rgba(231, 76, 60, 0.1);
            color: #c0392b;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .alert i {
            margin-right: 10px;
            font-size: 20px;
        }
        .form-control::placeholder {
            color: #bdc3c7;
            font-size: 14px;
        }
        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
            }
            .login-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>POS System</h2>
                <p>Please login to your account</p>
            </div>
            <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Invalid username or password
            </div>
            <?php endif; ?>
            <form action="../../action/login/auth_login.php" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           placeholder="Enter your username">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Enter your password">
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="btn btn-login">
                    Login <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            <div class="login-footer">
                &copy; <?php echo date('Y'); ?> POS System. All rights reserved.
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>