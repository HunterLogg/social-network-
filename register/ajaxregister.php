<?php
require_once("../DBController.php");
$db_handle = new DBController(); 
session_start();
$action= $_GET['action'];
?>
<?php
    if($action == "register"){
        $fname = ($_POST['firstname']);
        $lname = ($_POST['lastname']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $day = ($_POST['day']);
        $month = ($_POST['month']);
        $year = ($_POST['year']);
        $gender = ($_POST['gender']);
        $date = $day . '-' .  $month. '-' . $year;
        if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $query = "SELECT email FROM users WHERE email ='$email'";
                $result = $db_handle->runQuery($query);
                if(!empty($result)){
                    echo "$email - this email alredy exist!";
                }else {
                    $status = "Active now";
                    $random_id = rand(time(), 10000000);
                    $query2 ="INSERT INTO users (unique_id,firstname,lastname,email,password,dob,gender,status) 
                            VALUES ($random_id,'$fname', '$lname','$email','$password','$date','$gender','$status')";
                    $sql = $db_handle->insert($query2);
                    $sql1 = $db_handle->runQuery("SELECT * FROM users WHERE email ='$email'");
                    $unique_id = $sql1[0]['unique_id'];
                    $_SESSION['unique_id']= $unique_id;
                    $_SESSION['valdiation_code'] = md5($random_id);
                    echo "success" ;
                }
            }
        }
        else {
            echo "Vui lòng nhập email";
        }  
    }else if($action == "confirm"){
        $unique_id = $_SESSION['unique_id'];
        $valdiation_code = $_SESSION["valdiation_code"];
        $valdiation = $_POST["valdiation"];
        $contact = $_POST["contact"];
        if($valdiation == null || !isset($_FILES['img_file']) || $contact==null){
            echo "Please input code or select img file or input your contact!";
        }
        else if($valdiation == $valdiation_code){
            if(isset($_FILES['img_file'])){
                $img_name = $_FILES['img_file']['name'];
                $tmp_name = $_FILES['img_file']['tmp_name'];
            
                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);
            
                $extension = ['png','jpeg','jpg']; 
                if(in_array($img_ext,$extension) === true ){
                    move_uploaded_file($tmp_name,"../img/avartar/".$img_name);
                    $query = "UPDATE users SET img_user='$img_name' , contact = '$contact' where unique_id = '$unique_id' ";
                    $sql = $db_handle->update($query);
                    $query1 = "SELECT * FROM users where unique_id = '$unique_id' ";
                    $sql1 = $db_handle->runQuery($query1);
                    $email = $sql1[0]['email'];
                    $_SESSION['email'] = $email;
                    echo "success" ;
                }
                else {
                    echo "Please select an Image file -png,jpeg,jpg!";
                }
            }
        }
        else {
            echo "Code was wrong.Please input again!";
        }
    }

?>