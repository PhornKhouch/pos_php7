<?php
include '../../root/Header.php';
include '../../Config/conect.php';

session_start();
if(isset($_GET['id'])!=null){
    $id = $_GET['id'];
    $sql = "SELECT * FROM `users` WHERE `id`='$id'";
    $result = $con->query($sql);
    if($result){
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $password = $row['password'];
        $full_name = $row['full_name'];
        $email = $row['email'];
        $role = $row['role'];
        $expired_date = $row['date_exp'];
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Add User</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/user/actionedit.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnupdate" class="btn btn-primary" value="Update">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6" style="display:none;">
                        <label for="">ID</label>
                        <input type="text" class="form-control" name="id" value="<?php echo $id; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="Username" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Password</label>
                        <input type="text" class="form-control" name="Password" value="<?php echo $password; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Full Name</label>
                        <input type="text" class="form-control" name="Fullname" value="<?php echo $full_name; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="Email" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Role</label>
                        <select name="role" id="" class="form-control">
                            <option value="Admin" <?php if($role=='Admin'){echo 'selected';}?>>Admin</option>
                            <option value="staff" <?php if($role=='staff'){echo 'selected';}?>>staff</option>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">User expired Date</label>
                        <input type="date" class="form-control" name="ExpiredDate" value="<?php echo $expired_date; ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php include '../../root/Footer.php'; ?>
<script>
    const imgPreview = document.getElementById('imgPreview');
    const fileInput = document.getElementById('fileupload');
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.addEventListener('load', () => {
            imgPreview.src = reader.result;
        });
        reader.readAsDataURL(file);
    });
</script>

</html>