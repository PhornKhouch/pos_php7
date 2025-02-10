<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnsave'])){
        //get data from Form
        $code = $_POST['code'];
        $description = $_POST['name'];
        $status = $_POST['status'];

        //save data to database
        $sql = "INSERT INTO `category` (`code`, `name`, `status`) VALUES ('$code', '$description', '$status')";
        if($con->query($sql)){
            //Set success message
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Category saved successfully!";
            header('Location:../../view/category/index.php');
            exit();
        }else{
            //Set error message
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Error saving category: " . $con->error;
            header('Location:../../view/category/index.php');
            exit();
        }
    }
?>