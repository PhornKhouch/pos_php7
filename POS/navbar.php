<?php
include("root/header.php");
?>
<style>
    .box {
        width: 90%;
        min-height: 100vh;
        /* display:flex;
    justify-content:center;
    align-items:center; */
        font-size: 35px;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        animation-name: test;
        animation-duration: 6s;
        animation-iteration-count: infinite;
        text-shadow: 3px 3px 4px black;
        float: left;
    }

    @keyframes test {
        0% {
            color: blue;

        }

        50% {
            color: green;
        }

        100% {
            color: purple;
        }
    }

    .login{
        width: 10%;
        min-height: 100vh;
        /* background-color: red; */
        float: left;
        display: flex;
        justify-content: center;
        align-items: center;
        
    }
    .login input{
        transform: translateX(25px);
    }
</style>
</head>

<body style="background-color:red">
    <div class="container-fluid bg-primary" style='min-height:100vh'>
        <div class='box'>
            <h1>POS-Club Code</h1>
        </div>
        <div class="login">
           <a href="view/Login/confirm_logout.php" target="content" class="btn btn-info">Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>