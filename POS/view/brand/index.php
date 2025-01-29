<?php
include '../../root/Header.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    if (isset($_SESSION['msg']) != null) {
    ?>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "<?php echo $_SESSION['msg']; ?>"
            });
        </script>
    <?php
        unset($_SESSION['msg']);
    }
    ?>

    <div class="container mt-5 mb-2">
        <h1>Brand Management</h1>

        <div class="row mt-3 bg-success p-2">
            <div class="">
                <a href="add.php" class="btn btn-primary">Add New Brand</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../Config/conect.php';
                        $sql = "SELECT B.*,
                                C.name AS categoryname
                                FROM `brand`  B
                                INNER JOIN category  C ON B.category=C.code";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['categoryname']; ?></td>
                                    <td><?php
                                        if ($row['status'] == 'A') {
                                            echo 'Active';
                                        } else {
                                            echo 'InActive';
                                        }
                                        ?></td>
                                    <td>
                                        <img src="/PHP7/POS/Upload/brand/<?php echo $row['photo']; ?>" width="100">
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['code']; ?>" class="btn btn-primary">Edit</a>
                                        <a href='javascript:void(0)' class="btn btn-primary" onclick='deleteRecord("<?php echo $row['code']; ?>")'>Delete</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<?php include '../../root/Footer.php'; ?>

<script>
    function deleteRecord(id) {
        //alert to confrim
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //link to page action
                window.location.href = '/PHP7/POS/action/brand/actiondelete.php?code=' + id;
            }
        })
    }
</script>

</html>