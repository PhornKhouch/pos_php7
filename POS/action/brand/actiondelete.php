<?php
include '../../Config/conect.php';
session_start();
if(isset($_GET['code'])!=null){
    $code = $_GET['code'];
    $sql = "DELETE FROM `brand` WHERE `code`='$code'";
    $result = $con->query($sql);
    if($result){
        $_SESSION['msg'] = "Delete successfully";
        header('Location:../../view/brand/index.php');
        exit();
    }
}
?>