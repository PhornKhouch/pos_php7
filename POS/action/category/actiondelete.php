<?php
include '../../Config/conect.php';
session_start();
if(isset($_GET['code'])!=null){
    $code = $_GET['code'];
    $sql = "DELETE FROM `category` WHERE `code`='$code'";
    $result = $con->query($sql);
    if($result){
        $_SESSION['msg'] = "Delete successfully";
        header('Location:../../view/category/index.php');
        exit();
    }
}
?>