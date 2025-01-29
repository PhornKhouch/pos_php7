<?php
    include('../../Config/conect.php');
    session_start();

    if(isset($_POST['btnsave'])){
        $payment = $_POST['payment'];
        $unit = $_POST['unit'];
        $stats = $_POST['status'];
        // Check if ID exists - if yes, update; if no, insert
        if(!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "UPDATE `setting` SET `payment_method`='$payment', `unit`='$unit', `Status`='$stats' WHERE `id`='$id'";
        } else {
            $sql = "INSERT INTO `setting`(`payment_method`, `unit`,`Status`) VALUES ('$payment','$unit','$stats')";
        }
        
        $result = $con->query($sql);
        if($result){
            header('Location: /PHP7/POS/view/settings/index.php?success=1');
            exit();
        }else{
            header('Location: /PHP7/POS/view/settings/index.php?error=1');
            exit();
        }
    } 

    if(isset($_GET['action']) && $_GET['action'] == "btndelete"){
        $id = $_GET['id'];
        $sql = "DELETE FROM `setting` WHERE `id`='$id'";
        $result = $con->query($sql);
        if($result){
            header('Location: /PHP7/POS/view/settings/index.php?success=1');
            exit();
        }else{
            header('Location: /PHP7/POS/view/settings/index.php?error=1');
            exit();
        }
    } 
?>