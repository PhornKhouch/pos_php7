<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnsave'])){
        //get data from Form
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $full_name = $_POST['Fullname'];
        $email = $_POST['Email'];
        $role = $_POST['role'];
        $expired_date = $_POST['ExpiredDate'];
        
        //save data to database
        $sql = "INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `created_at`, `updated_at`, `date_exp`) VALUES 
        (NULL, '$username', '$password', '$full_name', '$email', '$role', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$expired_date');";
        try{
            if($con->query($sql)){
                //redirect to index.php
                $_SESSION['msg'] = "Save successfully";
                header('Location:../../view/user/index.php');
            }  
        }
        catch(Exception $e){
            $_SESSION['msg']="Error: " . $sql . "<br>" . $con->error;
            header('Location:../../view/user/index.php');
            exit();
        }
        
    }
?>