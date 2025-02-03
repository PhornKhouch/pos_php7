<?php
include '../../root/Header.php';
include '../../Config/conect.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Add User</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/user/actioncreate.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnsave" class="btn btn-primary" value="Save">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="Username">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Password</label>
                        <input type="text" class="form-control" name="Password">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Full Name</label>
                        <input type="text" class="form-control" name="Fullname">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="Email">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Role</label>
                        <select name="role" id="" class="form-control">
                            <option value="Admin">Admin</option>
                            <option value="staff">staff</option>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">User expired Date</label>
                        <input type="date" class="form-control" name="ExpiredDate">
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