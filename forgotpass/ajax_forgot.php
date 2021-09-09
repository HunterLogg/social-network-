<?php 
    session_start();
    require_once("../DBController.php");
    $db_handle = new DBController();
    $action = $_GET['action'];
    if($action=="send"){
        $email_forgot = $_POST['forgot_email'];
        $query = "SELECT * FROM users WHERE email = '$email_forgot' or contact = '$email_forgot'";
        $result = $db_handle->runQuery($query);
        if(!empty($result)){
            $email = $result[0]['email'];
            $_SESSION['email'] = $email;
            $random_code = rand(time(), 10000000);
            $_SESSION['random_code']= $random_code;
            $msg = "Mã xác thực của bạn là: " . $random_code;
            $subject = "Mã xác thực.";
            $sender = "From: tuanlongauto@gmail.com";
            if(mail($email, $subject, $msg, $sender)){
                echo "success";
            }
            //echo $random_code;
        }else {
            echo "Email hoặc số điện thoại không đúng vui lòng nhập lại.";
        }
    }
    else if($action == "confirm"){
        $code = $_SESSION['random_code'];
        $code_confirm = $_POST['code'];
        if($code == $code_confirm){
            echo "success";
        }else {
            echo "Vui lòng nhập lại mã.";
        }

    }
    else if($action == "changepass"){
        $pass = $_POST['password'];
        $c_pass = $_POST['c-password'];
        $email = $_SESSION['email'];
        if(!empty($pass) || !empty($c_pass)){
            if($pass == $c_pass){
                if(preg_match('/^[a-zA-Z0-9._-]{6,15}$/',$pass)){
                    $query = "UPDATE users SET password='$pass' where email = '$email' ";
                    $result = $db_handle->update($query);
                    echo "success";
                }
                else {
                    echo "Please try again your pass!";
                }
            }
            else {
                echo "Vui lòng xác thực lại mật khẩu ";
            }
        }
        else {
            echo "Vui lòng nhập mật khẩu và xác thực lại. ";
        }
    }

?>