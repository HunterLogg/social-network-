<?php 
require_once("../DBController.php");
session_start();
$db_handle = new DBController(); 
$query = "SELECT * FROM users";
$result = $db_handle->runQuery($query);
$email = $_SESSION['email'];
$query1 = "SELECT * FROM users WHERE email = '$email'";
$sql = $db_handle->runQuery($query1);
$user_id_add = $sql[0]['id'];
$output ="";
if(empty($result)){
    $output = "Không có user nào.";
}
else {
    foreach($result as $value){
        if($value['email'] != $email){
        $output .= '<a href="#" class="d-flex py-2 px-1 text-dark side-nav rounded btn">
                    <div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
                    <img src="../img/avartar/'. $value['img_user'] .'" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                    </div>
                    <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                    <span class="" style="margin-top: 7px;"><b>'.$value['firstname']. " " . $value['lastname'].'</b></span>
                    <button type="button" class="btn btn-secondary btn-addfriend" style="margin-left: 30px">Thêm bạn bè</button>
                    </a>
                    
                    <hr>';
        }
    }
    echo $output;
    
}

?>
