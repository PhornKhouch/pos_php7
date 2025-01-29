<?php
include '../../root/Header.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Add category</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/category/actioncreate.php" method="post">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnsave" class="btn btn-primary" value="Save">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Code</label>
                        <input type="text" class="form-control" name="code">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-xl-6">
                        <label for="">status</label>
                        <select name="status" id="" class="form-control">
                            <option value="A">Active</option>
                            <option value="I">InActive</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php include '../../root/Footer.php'; ?>

</html>