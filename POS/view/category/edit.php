<?php
include '../../root/Header.php';
include '../../Config/conect.php';
session_start();
if(isset($_GET['id'])!=null){
    $id = $_GET['id'];
    $sql = "SELECT * FROM `category` WHERE `code`='$id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();//convert data to array associative
    $code = $row['code'];
    $name = $row['name'];
    $status = $row['status'];
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Edit category</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/category/actionedit.php" method="post">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnupdate" class="btn btn-primary" value="Update">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Code</label>
                        <input type="text" class="form-control" name="code" value="<?php echo $code;?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">status</label>
                        <select name="status" id="" class="form-control">
                            <option value="A" <?php if($status=='A'){echo 'selected';}?>>Active</option>
                            <option value="I" <?php if($status=='I'){echo 'selected';}?>>InActive</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php include '../../root/Footer.php'; ?>

</html>