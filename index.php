<?php 
include("login/login.php");

if(isset( $_GET['logout'])){
    require_once("DBController.php");
     $db_handle = new DBController(); 
    unset($_SESSION['email']);
    $id = $_GET['id'];
    $db_handle->update("UPDATE users SET status = 'Offline' where id = '$id' ");
}
?>

