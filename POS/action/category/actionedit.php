<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnupdate'])){
        //get data from Form
        $code = $_POST['code'];
        $description = $_POST['name'];
        $status = $_POST['status'];

        //save data to database
        $sql = "UPDATE `category` SET `code`='$code',`name`='$description',`status`='$status' WHERE `code`='$code'";
        if($con->query($sql)){
            //redirect to index.php
            $_SESSION['msg'] = "Update successfully";
            header('Location:../../view/category/index.php');
        }else{
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
?>