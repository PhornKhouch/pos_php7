<?php
include '../../root/Header.php';
include '../../Config/conect.php';
session_start();
if(isset($_GET['id'])!=null)
{
    $code=$_GET['id'];
    $sql="SELECT * FROM brand WHERE code='$code'";
    $result=$con->query($sql);
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc();
        $code=$row['code'];
        $name=$row['name'];
        $categoryCode=$row['category'];
        $status=$row['status'];
        if($row['photo']!=null || $row['photo']!=''){
            $src="../../Upload/brand/".$row['photo'];
        }
        else{
            $src='../../Upload/brand/camera.jpg';
        }

    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-2">
        <h1>Add brand</h1>

        <div class="row mt-3 p-2">
            <form action="/PHP7/POS/action/brand/actionedit.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <a href="index.php" class="btn btn-primary">Back</a>
                        <input type="submit" name="btnupdate" class="btn btn-primary" value="Save">
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
                        <label for="">Category</label>
                        <select name="category" id="" class="form-select">
                            <?php
                                $category="SELECT * FROM category Where status='A'";
                                $result = $con->query($category);
                               
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['code']; ?>" <?php if($row['code']==$categoryCode){echo "selected";}?>><?php echo $row['name']; ?></option>
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
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="col-xl-6">
                        
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

</html>