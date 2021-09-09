<?php
session_start();
require_once("../DBController.php");
$db_handle = new DBController(); 

$email = $_SESSION['email'] = $_POST['email'];
$password = $_POST['password'];
if(!empty($email) && !empty($password)){
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $db_handle->runQuery($query);
    if(!empty($result)){
        $id = $result[0]['id'];
        $db_handle->update("UPDATE users SET status = 'Active now' where id = '$id' ");
        echo "success";
    }else {
        echo "Email or Password was wrong!";
    }
}
else {
    echo "Please input your email or password";
}
?>