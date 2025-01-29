<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnupdate'])){
        //get data from Form
        $id = $_POST['id'];
        $description = $_POST['name'];
        $category = $_POST['category'];
        $brand  = $_POST['brand'];
        $qty = $_POST['qty'];
        $stdate = $_POST['stockdate'];
        $unitcose = $_POST['cost'];
        $exdate = $_POST['expdate'];
        $Active= $_POST['isactive'];
        if($Active=='on'){
            $Active='A';
        }else{
            $Active='I';
        }
        $unit= $_POST['unit'];
        
        //upload photo
        $target_dir = "../../Upload/brand/";
        $filename=$_FILES['photo']['name'];
        $tmp_name=$_FILES['photo']['tmp_name'];
        $imageFileType = move_uploaded_file($tmp_name, $target_dir . $filename);
       

        //save data to database
        $sql = "
        UPDATE `prdmaster` SET 
        `prdname` = '$description',
        photo = '$filename', 
        `prdcategroy` = '$category', 
        `prdbrand` = '$brand', 
        `stockdate` = '$stdate', 
        `expdate` = '$exdate', 
        `stockqty` = '$qty', 
        `unitcose` = '$unitcose', 
        `isactive` = '$Active', 
        `photo` = '$filename' 
        WHERE `prdmaster`.`id` = '$id';
        ";
        if($con->query($sql)){
            //redirect to index.php
            $_SESSION['msg'] = "Update successfully";
            header('Location:../../view/prdmaster/index.php');
        }else{
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
?>