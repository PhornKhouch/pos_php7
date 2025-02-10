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
                icon: "warning",
                title: "<?php echo $_SESSION['msg']; ?>"
            });
        </script>
    <?php
        unset($_SESSION['msg']);
    }
    ?>
    <div class="container mt-5 mb-2">
        <h1>Add Product Master</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/prdmaster/actioncreate.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnsave" class="btn btn-primary" value="Save">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <label for="">Product name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    
                    <div class="col-xl-6">
                        <label for="">Category</label>
                        <select name="category" id="" class="form-select">
                            <?php
                                $category="SELECT * FROM category Where status='A'";
                                $result = $con->query($category);
                               
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                }
                               
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">Brand</label>
                        <select name="brand" id="" class="form-select">
                            <?php
                                $brand="SELECT * FROM brand Where status='A'";
                                $result = $con->query($brand);
                               
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                }
                               
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="qty">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Unit Cost</label>
                        <input type="number" class="form-control" name="cost">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Stock Date</label>
                        <input type="date" class="form-control" name="stockdate">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Expired Date</label>
                        <input type="date" class="form-control" name="expdate">
                    </div>
                    <div class="col-xl-6 " style="margin-top: 40px;">
                        <label for="">Active</label>
                        <input style="margin-left: 15px;" type="checkbox" name="isactive" class="form-check-input"> 
                    </div>
                    <div class="col-xl-6">
                    <label for="">Telegram Alert</label>
                        <select name="TelegramID" id="" class="form-select">
                            <?php
                                $tele="SELECT * FROM telegram";
                                $result = $con->query($tele);
                               
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['groupid']; ?>"><?php echo $row['groupid']; ?></option>
                                    <?php
                                }
                               
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">photo</label>
                        <input type="file" name="photo" id="fileupload" class="form-control">
                    </div>
                    <div class="col-xl-6">
                    <label for="">Unit</label>
                        <select name="unit" id="" class="form-select">
                            <?php
                                $unit="SELECT * FROM setting";
                                $result = $con->query($unit);
                               
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['unit']; ?>"><?php echo $row['unit']; ?></option>
                                    <?php
                                }
                               
                            ?>
                        </select>
                    </div>

                    <div class="col-xl-6 mt-5">
                        <img src="../../Upload/brand/camera.jpg" alt="" id="imgPreview" width="200px" height="120px" style="object-fit: contain;">
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