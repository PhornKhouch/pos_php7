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
            //redirect to index.php
            $_SESSION['msg'] = "Save successfully";
            header('Location:../../view/category/index.php');
        }else{
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
?>