<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnsave'])){
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
        $sql = "INSERT INTO `brand` (`code`, `name`, `category`, `status`, `photo`)
         VALUES ('$code', '$description', '$category', '$status', '$filename');";
        try{
            if($con->query($sql)){
                //redirect to index.php
                $_SESSION['msg'] = "Save successfully";
                header('Location:../../view/brand/index.php');
            }  
        }
        catch(Exception $e){
            $_SESSION['msg']="Error: " . $sql . "<br>" . $con->error;
            header('Location:../../view/brand/index.php');
            exit();
        }
        
    }
?>