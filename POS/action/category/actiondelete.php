<?php
include '../../Config/conect.php';
session_start();
if(isset($_GET['code'])!=null){
    $code = $_GET['code'];
    try {
        $sql = "DELETE FROM `category` WHERE `code`='$code'";
        $result = $con->query($sql);
        
        if($result){
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = "Category deleted successfully";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['status'] = 'error';
        // Check if it's a foreign key constraint error
        if(strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            $_SESSION['message'] = "Cannot delete this category because it is being used by other records";
        } else {
            $_SESSION['message'] = "Error deleting category: " . $e->getMessage();
        }
    }
    
    header('Location:../../view/category/index.php');
    exit();
}
?>