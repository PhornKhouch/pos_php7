<?php
include '../../root/Header.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    table thead th{
        text-transform: uppercase;
    }
</style>
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

    <div class="container-fluid mt-5 mb-2">
        <h1>Product Management</h1>

        <div class="row mt-3 bg-success p-2">
            <div class="">
                <a href="add.php" class="btn btn-primary">Add New Product</a>
                <a href="export_excel.php" class="btn btn-primary">Export to Excel</a>
                <a href="export_pdf.php" class="btn btn-primary">Export to PDF</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>image</th>
                            <th>Product name</th>
                            <th>Category</th>
                            <th>brand</th>
                            <th>stock date</th>
                            <th>Expired date</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Status</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../Config/conect.php';
                        $sql = "SELECT 
                            M.*,
                            B.name AS brandName,
                            C.name AS categoryname
                            FROM `prdmaster` M
                            INNER JOIN category C ON C.code=M.prdcategroy
                            INNER JOIN brand B ON B.code=M.prdbrand
                        ";
                        $i=1;
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <img src="../../Upload/brand/<?php echo $row['photo']; ?>" alt="" width="40px">
                                    </td>
                                    <td><?php echo $row['prdname']; ?></td>
                                    <td><?php echo $row['categoryname']; ?></td>
                                    <td><?php echo $row['brandName']; ?></td>
                                    <td><?php  echo $row['stockdate']; ?></td>
                                    <td><?php  echo $row['expdate']; ?></td>
                                    <td><?php echo $row['stockqty']; ?></td>
                                    <td><?php echo $row['unitcose']; ?></td>
                                    <td>
                                       <?php 
                                            if($row['isactive'] == 'A'){
                                                echo '<span class="badge bg-success">Active</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">Inactive</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <button onclick="deleteRecord(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</button>
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
                window.location.href = '/PHP7/POS/action/prdmaster/actiondelete.php?code=' + id;
            }
        })
    }
</script>

</html>