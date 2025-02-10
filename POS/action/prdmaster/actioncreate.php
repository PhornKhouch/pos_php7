<?php
    include('../../Config/conect.php');
    session_start();
    if(isset($_POST['btnsave'])){
        //get data from Form
        $description = $_POST['name'];
        $category = $_POST['category'];
        $brand  = $_POST['brand'];
        $qty = $_POST['qty'];
        $stdate = $_POST['stockdate'];
        $exdate = $_POST['expdate'];
        $unitcose = $_POST['cost'];
        $Active= $_POST['isactive'];
        if($Active=='on'){
            $Active='A';
        }else{
            $Active='I';
        }
        $unit= $_POST['unit'];
        $tele= $_POST['TelegramID'];
        //upload photo
        $target_dir = "../../Upload/brand/";
        $filename=$_FILES['photo']['name'];
        $tmp_name=$_FILES['photo']['tmp_name'];
        $imageFileType = move_uploaded_file($tmp_name, $target_dir . $filename);
       
        //validate data to database
        if($description==''){
            $_SESSION['msg'] = "Please enter product name";
            header('Location:../../view/prdmaster/add.php');
            exit();
        }
        if($category==''){
            $_SESSION['msg'] = "Please enter category"; 
            header('Location:../../view/prdmaster/add.php');
            exit();
        }
        if( $qty==''){
            $_SESSION['msg'] = "Please enter quantity";
            header('Location:../../view/prdmaster/add.php');
            exit();
        }
        if( $stdate==''){
            $_SESSION['msg'] = "Please enter stock date";
            header('Location:../../view/prdmaster/add.php');
            exit();
        }
        if( $exdate==''){
            $_SESSION['msg'] = "Please enter exp date";
            header('Location:../../view/prdmaster/add.php');
            exit();
        }
        $sql = "INSERT INTO `prdmaster` (`id`, `prdname`, `prdcategroy`, `prdbrand`, `stockqty`, `unitcose`, `stockdate`, `expdate`, `createby`, `createdon`, `changedby`, `changedon`, `photo`, `isactive`, `unit`, `telegram_group`) 
        VALUES (NULL, '$description', '$category', '$brand', '$qty', '$unitcose', '$stdate', '$exdate', 'Admin', NOW(), '', NOW(), '$filename', '$Active', '$unit', '$tele');";
        try{
            if($con->query($sql)){
                //redirect to index.php
                $_SESSION['msg'] = "Save successfully";
                header('Location:../../view/prdmaster/index.php');
            }  
        }
        catch(Exception $e){
            $_SESSION['msg']="Error: " . $sql . "<br>" . $con->error;
            header('Location:../../view/prdmaster/index.php');
            exit();
        }
        
    }
?>