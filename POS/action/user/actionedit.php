<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnupdate'])){
        //get data from Form
        $id = $_POST['id'];
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $full_name = $_POST['Fullname'];
        $email = $_POST['Email'];
        $role = $_POST['role'];
        $expired_date = $_POST['ExpiredDate'];

        //save data to database
        $sql = "
        UPDATE `users` SET `username` = '$username',`password` = '$password', `full_name` = '$full_name', 
        `email` = '$email', `role` = '$role', `date_exp` = '$expired_date' 
        WHERE `users`.`id` = '$id';
        ";
        if($con->query($sql)){
            //redirect to index.php
            $_SESSION['msg'] = "Update successfully";
            header('Location:../../view/user/index.php');
        }else{
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
?>