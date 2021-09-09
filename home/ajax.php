<?php 
     require_once("../DBController.php");
     $db_handle = new DBController(); 
     session_start();
     require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
     $action = $_GET['action'];
     $date = date("h:i:sa") . " " . date("d") . "-" . date("m")  . "-" . date("Y") ;
     if($action=="post"){
        $id = $_POST['id_user'];
        $type = $_POST['type'];
        $action = $_POST['action'];
        $post_id = $_POST['post_id'];
        $img_name = $_FILES['post_img']['name'];
        $tmp_name = $_FILES['post_img']['tmp_name'];
        $img_explode = explode('.',$img_name);
        $img_ext = end($img_explode);
        $extension = ['png','jpeg','jpg'];
        $output = "";
        if($action == "add"){
            if(in_array($img_ext,$extension) === true ){
                move_uploaded_file($tmp_name,"../img/posts/".$img_name);
                if(!empty($_POST['content'])){
                    $content = $_POST['content'];
                }else{
                    $content = "";
                }
                $query = "INSERT INTO posts(user_id,content,img_path,date,type)  VALUES ($id,'$content','$img_name', '$date' ,'$type')";
                $sql = $db_handle->insert($query);
            }else {
                $content = $_POST['content'];
                $query = "INSERT INTO posts(user_id,content,date,type)  VALUES ($id,'$content', '$date' ,'$type')";
                $sql = $db_handle->insert($query);
            }
        }
        else {
            $content = $_POST['content'];
            if(empty($img_name)){
                $query1 = "UPDATE posts SET content = '$content', date = '$date', type = '$type' WHERE id = '$post_id'";
                $db_handle->update($query1);
            }
            else{
                move_uploaded_file($tmp_name,"../img/posts/".$img_name);
                $query2 = "UPDATE posts SET content = '$content', img_path = '$img_name' , date = '$date', type = '$type' WHERE id = '$post_id'";
                $db_handle->update($query2);
            }
        }
        $output .= $_POST['taget'];
        echo $output ;
    }
    else if($action == 'delete-post'){
        $post_id_delete = $_POST['post_id_delete'];
        $query= "DELETE FROM posts WHERE id = '$post_id_delete'";
        $db_handle->update($query);
        $db_handle->update("DELETE FROM comments WHERE post_id = '$post_id_delete'");
    }
    else if($action == "like-post"){
        extract($_POST);
        $likes = $db_handle->runQuery("SELECT * FROM likes WHERE user_id = $user_id");
        if(empty($likes)){
            $query = "INSERT INTO likes(user_id ,post_id ,date)  VALUES ($user_id, $post_id, '$date')";
            $sql = $db_handle->insert($query);
        }
    }
    else if($action=="search-user"){
        $conn = $db_handle->connectDB();
        $searchTerm = mysqli_real_escape_string($conn,$_POST['searchTerm']);
        $query = "SELECT * FROM users WHERE firstname like '%{$searchTerm}%' OR lastname like '%{$searchTerm}%'";
        $result = $db_handle->runQuery($query);
        $output = "";
        $email = $_SESSION['email'];
        $query1 = "SELECT * FROM users WHERE email = '$email'";
        $sql = $db_handle->runQuery($query1);
        $user_id_add = $sql[0]['id'];
        if(!empty($result)){
            foreach($result as $value){
                if($value['email'] != $email){
                $output .= '<a href="user_profile.php?id='. $value['id'] .'" class="d-flex py-2 px-1 text-dark side-nav rounded btn">
                    <div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
                        <img src="../img/avartar/'. $value['img_user'] .'" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                    </div>
                    <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                    <span style="margin-top: 7px;"><b>'.$value['firstname']. " " . $value['lastname'].'</b></span>
                    </a>    
                    <hr>';
                }
            }
        }else{
            $output .= "No user found ";
        }
        echo $output;
    }
    else if($action == "comment"){
        //$query = "INSERT INTO posts(user_id,content,img_path,date,type)  VALUES ($id,'$content','$img_path', '$date' ,'$type')";
        extract($_POST);
        if($comment!=""){
            $query= "INSERT INTO comments (post_id, comment, user_id, date_created) VALUES ('$post_id', '$comment', '$user_id' ,'$date')";
            $db_handle->insert($query);
            $query1 = "SELECT * FROM users WHERE id = $user_id";
            $user = $db_handle->runQuery($query1);
            $user_img = $user[0]['img_user'];
            $user_name = $user[0]['firstname']. " " . $user[0]['lastname'];
            echo '<img class="img-circle img-sm" src="../img/avartar/'. $user_img .'" alt="">
                <div class="comment-text">
                <span class="username">
                <span class="uname">'.$user_name.'</span>
                <span class="text-muted timestamp" style="float: right;"><?php echo $time_comment; ?></span>
                </span>
                <span class="comment">
                '.$comment.'
                </span>
                </div>';
        }
        
    }
    else if($action =="friend"){
        
     extract($_POST);
        if($actions == "add"){
            $query = "SELECT * FROM relatives WHERE user_id = $user_id_add and friend_id = $user_friend_add";
            $result = $db_handle->runQuery($query);
            if(empty($result)){
                $querys = "INSERT INTO relatives(user_id, friend_id, confirm) VALUES ($user_id_add , $user_friend_add , '$actions')";
                $sql = $db_handle->insert($querys);
                echo "success";
            }
        } else if ($actions == "accept") {
            $friend = $db_handle->runQuery("SELECT * FROM relatives WHERE user_id = $user_friend_add and friend_id =  $user_id_add");
            if(!empty($friend)){
                $relative_id = $friend[0]['id'];
            }
            //$query = "UPDATE users SET img_user='$img_name' , contact = '$contact' where unique_id = '$unique_id' ";
            $query1 = "UPDATE relatives SET confirm = '$actions' where id = '$relative_id' ";
            $db_handle->update($query1);
            echo "succes";
        } else if ($actions == "delete"){
            $friend = $db_handle->runQuery("SELECT * FROM relatives WHERE user_id = $user_id_add and friend_id =  $user_friend_add");
            if(!empty($friend)){
                $relative_id = $friend[0]['id'];
                $query1 = "DELETE FROM relatives where id = '$relative_id' ";
                $db_handle->update($query1);
            }
            
            echo "succes";
        }
    }else if($action == "edit-account"){
        $fname = ($_POST['firstname']);
        $lname = ($_POST['lastname']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $cpassword = ($_POST['cpass']);
        $day = ($_POST['day']);
        $month = ($_POST['month']);
        $year = ($_POST['year']);
        $gender = ($_POST['gender']);
        $date = $day . '-' .  $month. '-' . $year;
        if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $query = "SELECT email FROM users WHERE email ='$email'";
                $result = $db_handle->numRows($query);
                if($result == 1){
                    if($password == $cpassword){
                        if(!preg_match('/^[a-zA-Z0-9._-]{6,30}$/',$password)){
                            echo "Vui lòng nhập lại password.";
                        }
                        else{
                            $query1 = "UPDATE users SET firstname = '$fname' , lastname = '$lname', email = '$email', password = '$password', dob = '$date', gender = '$gender'  WHERE email = '$email' ";
                            $sql = $db_handle->update($query1);
                            $_SESSION['date'] = $date;
                            echo "success";
                        }
                    }
                    else {
                        echo "Vui lòng nhập lại password hoặc comfirmpassword";
                    }
                }else {
                    echo "$email - this email does not exist!";
                }
            }
        }
        else {
            echo "Vui lòng nhập đầy đủ thông tin.";
        }  
    }
    else if($action == "insert_chat"){
        $incoming_msg_id = $_POST['incoming_msg'];
        $outgoing_msg_id = $_POST['outgoing_msg'];
        $text_message = $_POST['text-message'];
        if($_FILES['upload_file']['name'] != "" ){
            $img_name = $_FILES['upload_file']['name'];
            $tmp_name = $_FILES['upload_file']['tmp_name'];

            $img_explode = explode('.',$img_name);
            $img_ext = end($img_explode);

            $extension = ['png','jpeg','jpg']; 
            if(in_array($img_ext,$extension) === true ){
                move_uploaded_file($tmp_name,"../img/msg/".$img_name);
                $query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, date_send, img_name) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date', '$img_name')";
                $sql = $db_handle->insert($query);
            }
            else {
                $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                //tạo mảng chứa các đuôi file
                $allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(in_array($ext , $allowed)){
                    move_uploaded_file($tmp_name,"../files/upload/".$img_name);
                    $query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg , date_send, file_name) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date', '$img_name')";
                    $sql = $db_handle->insert($query);
                }
            }
        }else{
            if($text_message != ""){
                $query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, date_send) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date')";
                $sql = $db_handle->insert($query);  
            }
        }
    }
    else if($action == "insert_chat_group"){

        $id_group = $_POST['group_id'];
        $incoming_msg_id = $_POST['id_send'];
        $text_message = $_POST['text-message-group'];
        echo $id_group ;
        if($_FILES['upload_file_group']['name'] != ""){
            $img_name = $_FILES['upload_file_group']['name'];
            $tmp_name = $_FILES['upload_file_group']['tmp_name'];

            $img_explode = explode('.',$img_name);
            $img_ext = end($img_explode);

            $extension = ['png','jpeg','jpg']; 
            if(in_array($img_ext,$extension) === true ){
                move_uploaded_file($tmp_name,"../img/msg/".$img_name);
                $query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg , img_name, date_send) VALUES($incoming_msg_id, $id_group, '$text_message', '$img_name', '$date')";
                $sql = $db_handle->insert($query);
            }
            else {
                $ext = pathinfo($img_name, PATHINFO_EXTENSION);
                //tạo mảng chứa các đuôi file
                $allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(in_array($ext , $allowed)){
                    move_uploaded_file($tmp_name,"../files/upload/".$img_name);
                    $query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg , date_send, file_name) VALUES($incoming_msg_id, $id_group, '$text_message', '$date', '$img_name')";
                    $sql = $db_handle->insert($query);
                }
            }
        }else{
            if($text_message != ""){
                $query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg, date_send) VALUES($incoming_msg_id, $id_group, '$text_message', '$date')";
                $sql = $db_handle->insert($query);
            }
        }
    }
    else if($action == "get_chat"){
        extract($_POST);
        $output = "";
        if(!empty($incoming_msg_id)){
            //echo $outgoing_msg_id;
            $query = "SELECT * FROM messages WHERE incoming_msg_id = '$incoming_msg_id' and outgoing_msg_id= '$outgoing_msg_id' 
            or incoming_msg_id = '$outgoing_msg_id' and outgoing_msg_id= '$incoming_msg_id' ORDER BY id ASC";
            $messages = $db_handle->runQuery($query);
            $incoming = $db_handle->runQuery("SELECT * FROM users WHERE id = '$incoming_msg_id'");
            $incoming_name = $incoming[0]['firstname'] . " " . $incoming[0]['lastname'];
            $incoming_img = $incoming[0]['img_user'];
            $out = $db_handle->runQuery("SELECT * FROM users WHERE id = '$outgoing_msg_id'");
            $out_id = $out[0]['id'];
            $out_name = $out[0]['firstname'] . " " . $out[0]['lastname'];
            $out_img = $out[0]['img_user'];
            if(!empty($messages)){
                foreach($messages as $message){
                    $hide = "";
                    $hidemsg = "";
                    $hidefile = "";
                    $msg_file = $message['file_name'];
                    if(!$message['img_name']){
                        $hide = "none";
                    }
                    if($message['msg']=="" ){
                        $hidemsg = "none";
                    }
                    if($msg_file == ""){
                        $hidefile = "none";
                    }
                
                    if($message['outgoing_msg_id'] == $out_id){
                        
                        $output .= '<div class="d-flex align-items-center text-right justify-content-end ">
                                    <div class="pr-2"><p class="name">'. $incoming_name .'</p>
                                        <p class="msg" style="display: '. $hidemsg .'">'. $message['msg'] .'</p>
                                        <img src="../img/msg/'.$message['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
                                        <a class="btn btn-light text-primary" href="../files/upload/'. $msg_file .'" download  style="display: '.$hidefile.';">'. $msg_file .'</a>
                                    <div class=""><span class="between">'. $message['date_send'] .'</span></div>
                                    </div>
                                    <div><img src="../img/avartar/'. $incoming_img .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
                                    </div>';
                    }
                    else {
                        $output .= '<div class="d-flex align-items-center">
                        <div class="text-left pr-1"><img src="../img/avartar/'. $out_img .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
                        <div class="pr-2 pl-1"> <p class="name">'. $out_name .'</p>
                            <p class="msg" style="display: '. $hidemsg .'">'. $message['msg'] .'</p>
                            <img src="../img/msg/'.$message['img_name'].'" alt="" style=" width: 120px; height: 120px; display: '.$hide.';">
                            <a class="btn btn-light text-primary" href="../files/upload/'. $msg_file .'" download  style="display: '.$hidefile.';">'. $msg_file .'</a>
                            <div class=""><span class="between">'. $message['date_send'] .'</span></div>
                        </div>
                    </div>';
                    }
                }
                echo $output;
            }
        }
    }else if($action == "get_chat_group"){
        extract($_POST);
        $output = "";
        if(!empty($id_send)){
            //echo $outgoing_msg_id;
            $query = "SELECT * FROM group_chat WHERE  group_id= '$group_id'";
            $group_msgs = $db_handle->runQuery($query);
            if(!empty($group_msgs)){
                foreach($group_msgs as $group_msg){
                    $group_file =  $group_msg['file_name'];
                    $hidemsg = "";
                    $hidefile = "";
                    $hide = "";
                    if(!$group_msg['img_name'] ){
                        $hide = "none";
                    }
                    if($group_msg['msg']=="" ){
                        $hidemsg = "none";
                    }
                    if($group_file =="" ){
                        $hidefile = "none";
                    }
                    
                    if($group_msg['incoming_msg_id'] == $id_send){
                        $user_send = $db_handle->runQuery("SELECT * FROM users WHERE id = '$id_send'");
                        $user_send_name = $user_send[0]['firstname'] . " " . $user_send[0]['lastname'];
                        $output .= '<div class="d-flex align-items-center text-right justify-content-end ">
                                    <div class="pr-2"> <p class="name">'. $user_send_name .'</p>
                                        <p class="msg" style="display: '. $hidemsg .'">'. $group_msg['msg'] .'</p>
                                        <img src="../img/msg/'.$group_msg['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
                                        <a class="btn btn-light text-primary" href="../files/upload/'. $group_file .'" download  style="display: '.$hidefile.';">'. $group_file .'</a>
                                    <div class=""><span class="between">'. $group_msg['date_send'] .'</span></div>
                                    </div>
                                    <div><img src="../img/avartar/'. $user_send[0]['img_user'] .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
                                    </div>';
                    }
                    else {
                        $in_msg = $group_msg['incoming_msg_id'];
                        $user_send = $db_handle->runQuery("SELECT * FROM users WHERE id = '$in_msg'");
                        $user_send_name = $user_send[0]['firstname'] . " " . $user_send[0]['lastname'];
                        $output .= '<div class="d-flex align-items-center">
                        <div class="text-left pr-1"><img src="../img/avartar/'. $user_send[0]['img_user'] .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
                        <div class="pr-2 pl-1"> <p class="name">'. $user_send_name .'</p>
                            <p class="msg" style="display: '. $hidemsg .'">'. $group_msg['msg'] .'</p>
                            <img src="../img/msg/'.$group_msg['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
                            <a class="btn btn-light text-primary" href="../files/upload/'. $group_file .'" download  style="display: '.$hidefile.';">'. $group_file .'</a>
                            <div class=""><span class="between">'. $group_msg['date_send'] .'</span></div>
                        </div>
                    </div>';
                    }
                }
                echo $output;
            }
        }
    }else if($action == "create_group"){
        $group_name = $_POST['name_group'];
        if($group_name == ""){
            $group_name = $_POST['host_id'];
        }
        $host_id = $_POST['host_id'];
        $query = "INSERT INTO group_name (group_name, id_host) VALUES('$group_name', $host_id)";
        $sql = $db_handle->insert($query);
        $query1 = "SELECT * FROM users";
        $users = $db_handle->runQuery($query1);
        $conf = 0;
        foreach($users as $user){
            if(isset($_POST[''. $user['id'] .''])){
                $query2 = "SELECT * FROM group_name WHERE group_name = '$group_name'";
                $group = $db_handle->runQuery($query2);
                $group_id = $group[0]['id'];
                $mem_id = $user['id'];
                $query3 = "INSERT INTO group_mem(group_id, id_mem) VALUES ($group_id,$mem_id)";
                $sql1 = $db_handle->insert($query3);
                $conf = 1;
            }
        }if(isset($_POST['host_id'])){
            $host_id = $_POST['host_id'];
            $query4 = "INSERT INTO group_mem(group_id, id_mem) VALUES ($group_id,$host_id)";
            $sql1 = $db_handle->insert($query4);
        }
    }else if($action == "btn-add-group"){
        extract($_POST);
        $user = $db_handle->runQuery("SELECT * FROM users");
        $out_put = '<form action="" method="post" id="add-mem-group" class="" >
        <input type="hidden" name="groupid" id="groupid" value="'.$group_id_mem.'">';
        foreach($user as $u){
            $id_user_group = $u['id'];
            $have_group = $db_handle->runQuery("SELECT * FROM group_mem WHERE group_id ='$group_id_mem' and id_mem = '$id_user_group'");
            $have_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $id_user_group and user_id = $user_id and confirm = 'accept'
            or user_id = $id_user_group and friend_id = $user_id and confirm = 'accept' ");
            if(empty($have_group) && !empty($have_friend)){
                $out_put .= '
                <div class="form-group">
                    <label class="p-1 msg" for="'. $id_user_group .'"><span>'. $u['firstname'] . " " . $u['lastname'].'</span></label>
                    <input type="checkbox" class="form-check-input p-1" name="'. $id_user_group .'" id="'. $id_user_group .'" style="margin-left: 70px">
                </div>
                    ';
            }
        }
        $out_put .= '<button type="button" class="btn btn-success btn-acp">xác nhận</button>
        </form>
        <script >
        const add_mem_group = document.querySelector("#add-mem-group");
        add_mem_group.onsubmit = (e) => {
            e.preventDefault();
        }
        $(".btn-acp").click(function (e){
            $(".wrapper-add").hide();
            let xhr = new XMLHttpRequest();// tạo sml object
                xhr.open("POST","ajax.php?action=add-mem-group",true),
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);
                        }
                    }
                }
            let formData = new FormData(add_mem_group);
            xhr.send(formData);
        });
        </script>'
        ;
        echo $out_put;
    }else if($action == "add-mem-group"){
        $query = "SELECT * FROM users";
        $users = $db_handle->runQuery($query);
        $group_id = $_POST['groupid'];
        foreach($users as $user){
            if(isset($_POST[''. $user['id'] .''])){
                $mem_id = $user['id'];
                $query3 = "INSERT INTO group_mem(group_id, id_mem) VALUES ($group_id,$mem_id)";
                $sql1 = $db_handle->insert($query3);
                echo $group_id . $mem_id;
            }

        }
    }else if($action == "edit-img"){
        $user_id = $_POST['user_id'];
        $type = $_POST['type'];
        if(isset($_FILES['edit_cover'])){
            $img_name = $_FILES['edit_cover']['name'];
            $tmp_name = $_FILES['edit_cover']['tmp_name'];
        
            $img_explode = explode('.',$img_name);
            $img_ext = end($img_explode);
        
            $extension = ['png','jpeg','jpg']; 
            if(in_array($img_ext,$extension) === true ){
                move_uploaded_file($tmp_name,"../img/avartar/".$img_name);
                if($type == "cover"){
                    $query = "UPDATE users SET img_cover ='$img_name' where id = '$user_id' ";
                    $sql = $db_handle->update($query);
                }
                else {
                    $query = "UPDATE users SET img_user='$img_name' where id = '$user_id' ";
                    $sql = $db_handle->update($query);
                }
                echo "success" ;
            }
            else {
                echo "Please select an Image file -png,jpeg,jpg!";
            }
        }
    }else if($action == "send-email"){
    

    
    $email_to = $_POST['email_to'];
    $email = $_POST['email_user'];
    $subject = $_POST['theme'];
    $message = $_POST['msg_email'];
 
    //Load composer's autoloader
 
    $mail = new PHPMailer(true);                            
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = $email;     
        $mail->Password = '01213130824Az';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
 
        //Send Email
        $mail->setFrom($email);
 
        //Recipients
        $mail->addAddress($email_to);              
        $mail->addReplyTo($email);

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
        for ($i=0; $i < count($_FILES['file_email']['tmp_name']) ; $i++) { 
            # code...
            $img_name = $_FILES['file_email']['name'][$i];
            $tmp_name = $_FILES['file_email']['tmp_name'][$i];
            $img_explode = explode('.',$img_name);
            $img_ext = end($img_explode);
            $extension = ['png','jpeg','jpg','doc','docx','pdf','txt','gif','ppt','xlsx'];
            if(in_array($img_ext,$extension) === true ){
                $mail->addAttachment($tmp_name,$img_name);
            }

        }
        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "";
    }

    }

?>