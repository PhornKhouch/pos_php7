<?php 
include '../../root/Header.php';
include '../../Config/conect.php';

$id = null;
$payment = null;
$unit = null;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $select = "SELECT * FROM `setting` WHERE `id`='$id'";
    $result = $con->query($select);
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $payment = $row['payment_method'];
        $unit = $row['unit'];
    }
}
?>
<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <form action="/PHP7/POS/action/settings/actionsettings.php" method="post">
            <div class="row">
                <div class="col-6" style="display: none;">
                    <label for="inputEmail4" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>" readonly>
                </div>
                <div class="col-6">
                    <label for="inputEmail4" class="form-label">Payment method</label>
                    <input type="text" class="form-control" id="payment" name="payment" value="<?php echo htmlspecialchars($payment ?? ''); ?>" required>
                </div>
                <div class="col-6">
                    <label for="inputPassword4" class="form-label">Unit</label>
                    <input type="text" class="form-control" id="unit" name="unit" value="<?php echo htmlspecialchars($unit ?? ''); ?>" required>
                </div>
                <div class="col-6">
                    <label for="inputPassword4" class="form-label">status</label>
                    <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($unit ?? ''); ?>" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <input type="submit" name="btnsave" class="btn btn-primary" value="Save Changes">
                </div>
            </div>
        </form>


        <table id="example" class="table table-bordered mt-5" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payment Method</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select = "SELECT * FROM `setting`";
                $result = $con->query($select);
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($row['unit']); ?></td>
                        <td>
                            <a href="/PHP7/POS/view/settings/index.php?page=generalsettings&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/PHP7/POS/action/settings/actionsettings.php?id=<?php echo $row['id']; ?>&action=btndelete" class="btn btn-danger btn-sm">Delete</a>    
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<?php
// Check for success or error messages from the action page
if (isset($_GET['success'])) {
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Settings updated successfully',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    </script>";
}
if (isset($_GET['error'])) {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong',
            icon: 'error'
        });
    </script>";
}
?>
<?php include '../../root/Footer.php'; ?>
</html>