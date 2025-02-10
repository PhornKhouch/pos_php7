<?php
    include('../../Config/conect.php');
    session_start();

    if(isset($_POST['btnsave'])){
        $token = $_POST['token'];
        $chatid = $_POST['chatid'];
        $groupid = $_POST['groupid'];
        $status = $_POST['status'];
        $IsAlert = isset($_POST['IsAlert']) ? 1 : 0;
        
        // Check if ID exists - if yes, update; if no, insert
        if(!empty($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "UPDATE `telegram` SET `token`='$token', `chatid`='$chatid', `groupid`='$groupid', `status`='$status', `IsAlert`='$IsAlert' WHERE `id`='$id'";
        } else {
            $sql = "INSERT INTO `telegram`(`token`, `chatid`, `groupid`, `status`, `IsAlert`) VALUES ('$token','$chatid','$groupid','$status','$IsAlert')";
        }
        
        $result = $con->query($sql);
        if($result){
            header('Location: /PHP7/POS/view/settings/index.php?page=telegram&success=1');
            exit();
        }else{
            header('Location: /PHP7/POS/view/settings/index.php?page=telegram&error=1');
            exit();
        }
    } 

    if(isset($_GET['action']) && $_GET['action'] == "btndelete"){
        $id = $_GET['id'];
        $sql = "DELETE FROM `telegram` WHERE `id`='$id'";
        $result = $con->query($sql);
        if($result){
            header('Location: /PHP7/POS/view/settings/index.php?page=telegram&success=1');
            exit();
        }else{
            header('Location: /PHP7/POS/view/settings/index.php?page=telegram&error=1');
            exit();
        }
    }

    // Redirect back to index page if no action is specified
    header('Location: /PHP7/POS/view/settings/index.php?page=telegram');
    exit();
?>
