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
                <a href="../view/dashboard.php" target="content">Dasborad</a>
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
                        <a href="../view/Menu/index.php" target="content">User Management</a>
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
                        <a href="../view/sale/index.php" target="content">Point of Sale</a>
                    </li>
                    <!-- <li>
                        <a href="../AddNormalUser/index.php" target="content">Normal User</a>
                    </li> -->
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
                        <a href="../view/reportsale/stock_details.php" target="content">Stock Product</a>
                    </li>
                </ul>
            </li>
        </ul>
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