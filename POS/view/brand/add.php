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
        <h1>Add brand</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/brand/actioncreate.php" method="post" enctype="multipart/form-data">
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
                        <label for="">status</label>
                        <select name="status" id="" class="form-control">
                            <option value="A">Active</option>
                            <option value="I">InActive</option>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">photo</label>
                        <input type="file" name="photo" id="fileupload" class="form-control">
                    </div>
                    <div class="col-xl-6">
                        
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