<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }
    </style>
</head>
<body>
    <script>
    window.onload = function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Yes, logout!',
            allowOutsideClick: false,
            width: '400px',
            padding: '2em',
            background: '#fff',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to destroy session
                fetch('../../action/login/logout.php')
                    .then(() => {
                        window.parent.location.href = '../../view/Login/login.php';
                    });
            } else {
                // Go back to previous page
                window.history.back();
            }
        });
    }
    </script>
</body>
</html>