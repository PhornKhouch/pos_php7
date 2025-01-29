<?php
include '../../root/Header.php';
include '../../Config/conect.php';
session_start();
if(isset($_GET['id'])!=null){
    $id=$_GET['id'];
    $sql = "SELECT * FROM `prdmaster` WHERE `id`='$id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $prdname = $row['prdname'];
    $category = $row['prdcategroy'];
    $brand = $row['prdbrand'];
    $stockdate = $row['stockdate'];
    $expdate = $row['expdate'];
    $stockqty = $row['stockqty'];
    $unitcose = $row['unitcose'];
    $isactive = $row['isactive'];
    $unit = $row['unit'];
    if($row['photo']!=null || $row['photo']!=''){
        $src="../../Upload/brand/".$row['photo'];
    }
    else{
        $src='../../Upload/brand/camera.jpg';
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Update product Master</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/prdmaster/actionedit.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnupdate" class="btn btn-primary" value="Update">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-6" style="display:none;">
                        <label for="">Product name</label>
                        <input type="text" class="form-control" name="id" value="<?php echo $id; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Product name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $prdname; ?>">
                    </div>
                    
                    <div class="col-xl-6">
                        <label for="">Category</label>
                        <select name="category" id="" class="form-select">
                            <?php
                                $category="SELECT * FROM category Where status='A'";
                                $result = $con->query($category);
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['code']; ?>" <?php if($category==$row['code']){echo "selected";}?>><?php echo $row['name']; ?></option>
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
                                    <option value="<?php echo $row['code']; ?>" <?php if($brand==$row['code']){echo "selected";}?>><?php echo $row['name']; ?></option>
                                    <?php
                                }
                               
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-6">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="qty" value="<?php echo $stockqty; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Unit Cost</label>
                        <input type="number" class="form-control" name="cost" value="<?php echo $unitcose; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Stock Date</label>
                        <input type="date" class="form-control" name="stockdate" value="<?php echo $stockdate; ?>">
                    </div>
                    <div class="col-xl-6">
                        <label for="">Expired Date</label>
                        <input type="date" class="form-control" name="expdate" value="<?php echo $expdate; ?>">
                    </div>
                    <div class="col-xl-6 " style="margin-top: 40px;">
                        <label for="">Active</label>
                        <input style="margin-left: 15px;" type="checkbox" name="isactive" class="form-check-input" <?php if($isactive=='A'){echo "checked";}?> > 
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
                        <img src="<?php echo $src;?>" alt="" id="imgPreview" width="200px" height="120px" style="object-fit: contain;">
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