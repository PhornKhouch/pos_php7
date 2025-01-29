<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnupdate'])){
        //get data from Form
        $code = $_POST['code'];
        $description = $_POST['name'];
        $category = $_POST['category'];
        $status = $_POST['status'];

        //upload photo
        $target_dir = "../../Upload/brand/";
        $filename=$_FILES['photo']['name'];
        $tmp_name=$_FILES['photo']['tmp_name'];
        $imageFileType = move_uploaded_file($tmp_name, $target_dir . $filename);

        //save data to database
        $sql = "
        UPDATE `brand` SET `name` = '$description',photo = '$filename', `category` = '$category', `status` = '$status', `photo` = '$filename' 
        WHERE `brand`.`code` = '$code';
        ";
        if($con->query($sql)){
            //redirect to index.php
            $_SESSION['msg'] = "Update successfully";
            header('Location:../../view/brand/index.php');
        }else{
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
?>