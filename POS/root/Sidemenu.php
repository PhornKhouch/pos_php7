<?php
    include("header.php");
?>
</head>
<body style="background-color: black;">
    <div class="box">

    </div>
    <div class="menu">
        <br>
        <ul class="list-unstyled components ">
            <li>
                <a href="../view/dashboard.php" target="content"><i class="fa-solid fa-gauge" style="margin-right: 10px;"></i> Dasborad</a>
            </li>
            
            <!-- Set Up -->
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fa fa-cog" aria-hidden="true" style="margin-right: 10px;"></i>Setting</a>
                <ul class="collapse list-unstyled" id="homeSubmenu" style="margin-left: 20px;">
                    <li>
                        <a href="../view//settings/index.php" target="content">General Settings</a>
                    </li>
                    <li>
                        <a href="../view/user/index.php" target="content">User</a>
                    </li>
                </ul>
            </li>

            <!-- Product -->
            <li class="active">
                <a href="#Order" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fa fa-users" aria-hidden="true" style="margin-right: 10px;"></i>Product Management</a>
                <ul class="collapse list-unstyled" id="Order" style="margin-left: 20px;">
                    <li>
                        <a href="../view/category/index.php" target="content">Category</a>
                    </li>
                    <li>
                        <a href="../view/brand/index.php" target="content">Brand</a>
                    </li>
                    <li>
                        <a href="../view/prdmaster/index.php" target="content">Product Master</a>
                    </li>
                </ul>
            </li>

            <!-- POS -->
            <li class="active">
                <a href="#User" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fa-regular fa-money-bill-1" style="margin-right: 10px;"></i>Sale</a>
                <ul class="collapse list-unstyled" id="User" style="margin-left: 20px;">
                    <li>
                        <a href="../view/sale/index.php" target="content">Point of Sate</a>
                    </li>
                    <li>
                        <a href="../AddNormalUser/index.php" target="content">Normal User</a>
                    </li>
                </ul>
            </li>

            <!-- Report -->
            <li class="active">
                <a href="#Report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fa fa-book" aria-hidden="true" style="margin-right: 10px;"></i> Report</a>
                <ul class="collapse list-unstyled" id="Report" style="margin-left: 20px;">
                    <li>
                        <a href="../view/reportsale/sale_details.php" target="content">Sale Product</a>
                    </li>
                    <li>
                        <a href="../view/reportstock/stock_report.php" target="content">Stock Product</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <style>
        .logout-container {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }

        .Btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            background-color: rgb(231, 76, 60);
        }

        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 17px;
            transition: transform 0.3s ease;
        }

        .sign svg path {
            fill: white;
        }

        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1em;
            font-weight: 600;
            transition-duration: .3s;
            white-space: nowrap;
        }

        /* hover effect on button width */
        .Btn:hover {
            width: 140px;
            border-radius: 40px;
            transition-duration: .3s;
            background-color: rgb(192, 57, 43);
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 20px;
        }

        .Btn:hover .sign svg {
            transform: rotate(-180deg);
        }

        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }
    </style>
    <div class="logout-container">
        <button onclick="window.parent.frames['content'].location.href='../view/Login/confirm_logout.php'" class="Btn">
            <div class="sign">
                <svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                </svg>
            </div>
            <div class="text">Logout</div>
        </button>
    </div>
</body>
<?php include("footer.php"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });
    });
</script>
</html>