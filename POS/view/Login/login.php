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
    <title>CLUB CODE - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../Style/login.css">
</head>
<body>
    <!-- Splash Screen -->
    <div class="splash-screen" id="splashScreen">
        <div class="splash-logo">CLUB CODE</div>
        <div class="svg-loader">
            <svg height="0" width="0" viewBox="0 0 100 100" class="absolute">
                <defs class="s-xJBuHA073rTt" xmlns="http://www.w3.org/2000/svg">
                    <linearGradient class="s-xJBuHA073rTt" gradientUnits="userSpaceOnUse" y2="2" x2="0" y1="62" x1="0" id="b">
                        <stop class="s-xJBuHA073rTt" stop-color="#0369a1"></stop>
                        <stop class="s-xJBuHA073rTt" stop-color="#67e8f9" offset="1.5"></stop>
                    </linearGradient>
                    <linearGradient class="s-xJBuHA073rTt" gradientUnits="userSpaceOnUse" y2="0" x2="0" y1="64" x1="0" id="c">
                        <stop class="s-xJBuHA073rTt" stop-color="#0369a1"></stop>
                        <stop class="s-xJBuHA073rTt" stop-color="#22d3ee" offset="1"></stop>
                        <animateTransform repeatCount="indefinite" keySplines=".42,0,.58,1;.42,0,.58,1;.42,0,.58,1;.42,0,.58,1;.42,0,.58,1;.42,0,.58,1;.42,0,.58,1;.42,0,.58,1" keyTimes="0; 0.125; 0.25; 0.375; 0.5; 0.625; 0.75; 0.875; 1" dur="8s" values="0 32 32;-270 32 32;-270 32 32;-540 32 32;-540 32 32;-810 32 32;-810 32 32;-1080 32 32;-1080 32 32" type="rotate" attributeName="gradientTransform"></animateTransform>
                    </linearGradient>
                    <linearGradient class="s-xJBuHA073rTt" gradientUnits="userSpaceOnUse" y2="2" x2="0" y1="62" x1="0" id="d">
                        <stop class="s-xJBuHA073rTt" stop-color="#38bdf8"></stop>
                        <stop class="s-xJBuHA073rTt" stop-color="#075985" offset="1.5"></stop>
                    </linearGradient>
                </defs>
            </svg>
            <!-- C -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#b)" 
                    d="M 80,30 A 25,25 0 1 0 80,70" class="dash" pathLength="360"></path>
            </svg>
            <!-- L -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#d)" 
                    d="M 30,20 L 30,80 L 70,80" class="dash" pathLength="360"></path>
            </svg>
            <!-- U -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#c)" 
                    d="M 25,30 L 25,70 A 25,25 0 0 0 75,70 L 75,30" class="dash" pathLength="360"></path>
            </svg>
            <!-- B -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#b)" 
                    d="M 30,20 L 30,80 L 60,80 A 20,20 0 0 0 60,50 L 30,50 L 60,50 A 20,20 0 0 0 60,20 L 30,20" class="dash" pathLength="360"></path>
            </svg>
            <div class="w-2"></div>
            <!-- C -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#d)" 
                    d="M 80,30 A 25,25 0 1 0 80,70" class="dash" pathLength="360"></path>
            </svg>
            <!-- O -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#c)" 
                    d="M 50,20 A 25,25 0 0 1 75,45 A 25,25 0 0 1 50,70 A 25,25 0 0 1 25,45 A 25,25 0 0 1 50,20" class="spin" pathLength="360"></path>
            </svg>
            <!-- D -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#b)" 
                    d="M 30,20 L 30,80 L 50,80 A 30,30 0 0 0 50,20 L 30,20" class="dash" pathLength="360"></path>
            </svg>
            <!-- E -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100" width="100" height="100" class="inline-block">
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="8" stroke="url(#d)" 
                    d="M 30,20 L 70,20 L 70,35 L 30,35 L 30,50 L 60,50 L 60,65 L 30,65 L 30,80 L 70,80" class="dash" pathLength="360"></path>
            </svg>
        </div>
        <div class="loading-container">
            <div class="block-loader"></div>
            <div class="block-loader"></div>
            <div class="block-loader"></div>
        </div>
    </div>

    <div class="container">
        <div class="login-container" id="loginContainer">
            <div class="login-header">
                <h2>CLUB CODE</h2>
                <p>Please login to your account</p>
            </div>
            <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Invalid username or password
            </div>
            <?php endif; ?>
            <form action="../../action/login/auth_login.php" method="POST" id="loginForm">
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

    <!-- Login Progress Overlay -->
    <div class="login-progress-overlay" id="loginProgress">
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <div class="progress-text" id="progressText">Loading... 0%</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Splash screen timing
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const splashScreen = document.getElementById('splashScreen');
                const loginContainer = document.getElementById('loginContainer');
                
                // Fade out splash screen
                splashScreen.style.opacity = '0';
                
                // Show login container
                loginContainer.style.display = 'block';
                
                // Remove splash screen after fade out
                setTimeout(function() {
                    splashScreen.style.display = 'none';
                }, 500);
            }, 2000);

            // Handle login form submission
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const overlay = document.getElementById('loginProgress');
                const progressBar = document.getElementById('progressBar');
                const progressText = document.getElementById('progressText');
                
                overlay.style.display = 'flex';
                let progress = 0;
                
                const interval = setInterval(() => {
                    progress += 2;
                    if (progress <= 100) {
                        progressBar.style.width = progress + '%';
                        progressText.textContent = `Loading... ${progress}%`;
                    }
                    
                    if (progress === 100) {
                        clearInterval(interval);
                        this.submit();
                    }
                }, 50);
            });
        });
    </script>
</body>
</html>