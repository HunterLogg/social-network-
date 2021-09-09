<?php include("homeheader.php");
require_once("../DBController.php");
?>
<?php
$db_handle = new DBController(); 
$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email ='$email'";
$sql = $db_handle->runQuery($query);

$name = $sql[0]['firstname']. " " . $sql[0]['lastname'];
$imgPath = $sql[0]['img_user'];
$user_id = $sql[0]['id'];
$posts = $db_handle->runQuery("SELECT * FROM posts ORDER BY id DESC");

//$unique_id = $sql[0]['unique_id'];

?>
    <div class="d-flex w-100 h-100" >
        <div class="left-panel">
            <a href="user_profile.php?id=<?php echo $user_id; ?>" class="d-flex py-2 px-1 text-dark side-nav rounded btn mt-3 btn btn-lg">
                    <div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left: -40px">
                      <img src="../img/avartar/<?php echo $imgPath;?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                    </div>
                  <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                  <span class="ml-3" style="margin-top: 10px;"><b><?php echo $name; ?></b></span>
            </a>
            <hr>
            <span style="margin-left: 10px;">Người bạn có thể biết</span>
            <div id="user-know">
                <?php 
                $know = $db_handle->runQuery("SELECT * FROM users");
                foreach($know as $value){
                    if($value['email'] == $email){
                        continue;
                    }
                    $some_one = $value['id'];
                    $is_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $some_one and user_id = $user_id and confirm = 'accept' or user_id = $some_one and friend_id = $user_id and confirm = 'accept' ");
                    if(!empty($is_friend)){
                        continue;
                    }

                    
                ?>
                <a href="user_profile.php?id=<?php echo $some_one; ?>" class="d-flex py-2 px-1 text-dark side-nav rounded btn">
                <div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
                    <img src="../img/avartar/<?php echo $value['img_user']; ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                </div>
                <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                <span class="" style="margin-top: 7px;"><b><?php echo $value['firstname']. " " . $value['lastname']; ?></b></span>
                <!-- <button type="button" class="btn btn-secondary btn-addfriend" user-id-add="<?php echo $user_id;?>" user-friend-add="<?php echo $value['id'];?>" style="margin-left: 30px">Thêm bạn bè</button> </a>
                            <hr>-->
                <?php 
                $friend_delete_add = $db_handle->runQuery("SELECT * FROM relatives where user_id = $user_id and friend_id = $some_one and confirm = 'add' ");
                if(!empty($friend_delete_add)){
                    echo '<button type="button" class="btn btn-danger btn-delete-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Hủy lời mời</button> </a>
                    <hr>';
                }
                $friend_accept_add = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $user_id and user_id = $some_one and confirm = 'add' ");
                if(!empty($friend_accept_add)){
                    echo '<button type="button" class="btn btn-success btn-Accept-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Đồng ý</button> 
                    <button type="button" class="btn btn-danger btn-delete-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 5px">Từ chối</button> </a>
                    <hr>';
                }
                if(empty($friend_delete_add) && empty($friend_accept_add)){
                    echo '<button type="button" class="btn btn-light btn-addfriend" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Thêm bạn bè</button> </a>
                    <hr>';
                }
                
                } ?>
            </div>
            

        </div>
        <div class="center-panel py-3 px-2">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-widget">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="d-flex w-100">
                                    <div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left:-40px; padding: 5px;">
                                          <img  src="../img/avartar/<?php echo $imgPath?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                                    </div>
                                    
                                    <button class="btn btn-default ml-4 text-left" id="btn_write_post" type="button" style="width:calc(80%);border-radius: 50px !important;" data-toggle="modal" data-target="#write_post">
                                    <span><?php echo  $sql[0]['lastname'] ?> ơi, bạn đang nghĩ gì thế?</span></button>
                                </div>
                                <hr>
                                <div class="d-flex w-100 justify-content-center">
                                    <a href="" id="upload_post" class="btn btn-light text-dark post-link py-1 h5" style="border-radius: 50px !important;"><span class="ti-image text-success"></span> Photo/Video</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <?php 
                        foreach($posts as $value){
                            $date_post = $value['date'];
                            $post_id = $value['id'];
                            $content_post = $value['content'];
                            $imgPath_post = $value['img_path'];
                            $post_user_id = $value['user_id'];
                            $type = $value['type'];
                            $query1 = "SELECT * FROM users where id='$post_user_id' ";
                            $user_posts = $db_handle->runQuery($query1);
                            $post_user_name = $user_posts[0]['firstname']. " " . $user_posts[0]['lastname'];
                            $post_user_img = $user_posts[0]['img_user'];
                            $not_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $post_user_id and user_id = $user_id and confirm = 'accept' 
                            or user_id = $post_user_id and friend_id = $user_id and confirm = 'accept' ");
                            if(empty($not_friend) && $user_id != $post_user_id){
                                continue;
                            }
                            if($value['type'] == 0 && $user_id != $value['user_id']){
                                continue;
                            }
                            
                    ?>
                    <div class="content" style="margin-top: 20px; ">
                        <div class="card card-widget post-card" data-id="">
                            <div class="card-header">
                                <div class="user-block">
                                    <img class="img-circle" src="../img/avartar/<?php echo $post_user_img;?>" alt="User Image" style="max-width: calc(100%);">
                                    <span class="username"><a href="#"><?php echo $post_user_name; ?></a></span>
                                    <span class="description">Posted -  <?php echo $date_post;?></span>
                                </div>
                            <!-- /.user-block -->
                            <?php if($post_user_id == $user_id) 
                            echo '<div class="card-tools " style="float: right;">
                                  <div class="dropdown">
                                    <button type="button" class="btn btn-tool" data-toggle="dropdown" title="Manage">
                                    <i class="ti-more-alt"></i>
                                    </button>
                                  <div class="dropdown-menu" style="transform: translate3d(-109px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <button class="edit dropdown-item edit_post btn" data-toggle="modal" data-target="#write_post" taget="home" data-img="'. $imgPath_post .'" type="'. $type .'" 
                                    data="'. $content_post .'" data-id="'. $post_id .'">Edit</button>
                                    <button class="dropdown-item delete_post btn" data-toggle="modal" data-target="#detele_post" data-id="'. $post_id .'" href="">Delete</button>
                                  </div>
                                  </div>
                                  </div>';?>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-body">
                            <?php 
                                $protocal = array("http://", "https://", "fpt://");
                                $conf = 0 ;
                                foreach($protocal as $value) {
                                    if(strlen(strstr($content_post, $value)) > 0) {
                                        echo '<a class="content-field" style="margin-top: 20px" href="'.$content_post.'">'.$content_post.'</a> <br>';
                                        $conf = 1 ;
                                        break;
                                    }
                                }
                                if($conf == 0 ){
                                    echo '<p class="content-field" style="margin-top: 20px">'.$content_post.'</p>';
                                }
                                $like_count = $db_handle->numRows("SELECT * FROM likes WHERE post_id = $post_id");
                                $comment_count = $db_handle->numRows("SELECT * FROM comments WHERE post_id = $post_id");
                            ?>
                            <img src="../img/posts/<?php echo $imgPath_post?>" alt="" class="w-100" >
                            <button type="button" class="btn btn-default btn-sm" data-id="<?php echo $user_id; ?>" post_id =<?php echo $post_id ?> style="margin-top: 20px"><i class="ti-thumb-up"></i> Like</button>
                            <span class="text-muted counts" style="float:right; margin-top: 20px"><span class="like-count"><?php echo $like_count ?></span> <?php echo $like_count > 1 ? "likes" : "like" ?> - 
                            <span class="comment-count"><?php echo $comment_count ?></span> comments</span>
                        </div>
                        <div class="card-footer card-comments">
				        <?php 
                            $query2 = "SELECT * FROM comments WHERE post_id = $post_id";
                            $comments = $db_handle->runQuery($query2);
                            if(!empty($comments)){
                            foreach($comments as $comment){
                                $id_user_comment = $comment['user_id'];
                                $text_comment = $comment['comment'];
                                $time_comment = $comment['date_created'];
                                $user_comment = $db_handle->runQuery("SELECT * FROM users WHERE id = $id_user_comment");
                                $imgPath_user_comment = $user_comment[0]['img_user'];
                                $name_user_comment = $user_comment[0]['firstname']. " " . $user_comment[0]['lastname'];

				        ?>
				        <div class="card-comment">
				        	<img class="img-circle img-sm" src="../img/avartar/<?php echo $imgPath_user_comment; ?>" alt="">
                            
				        	<div class="comment-text">
				        	<span class="username">
				        		<span class="uname"><?php echo $name_user_comment; ?></span>
				        		<span class="text-muted timestamp" style="float: right;"><?php echo $time_comment; ?></span>
				        	</span>
				        	<span class="comment">
                                <?php echo $text_comment; ?>
				        	</span>
				            </div>
				        </div>
                        <?php } }?>
                        
				        <!-- /.card-footer -->
                        <div class="card-footer">
                              <form action="#" method="post">
                                <i class="img-fluid img-circle img-sm ti-comments" style="float:left ; margin-top: 10px"></i>
                                <div class="img-push">
                                  <textarea cols="30" rows="1" class="form-control comment-textfield" style="resize:none; float:right;" placeholder="Press enter to post comment" name="comment-text" 
                                  user-id="<?php echo $user_id; ?>" data-id="<?php echo $post_id; ?>"></textarea>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="right-panel">
            <hr>
            <span>Người liên hệ</span>
            <div class="card-header">
				<div class="input-group">
						<input type="text" placeholder="Search..." name="" class="form-control">
					<div class="input-group-prepend">
                        <div class="input-group-text">
						<span class="input-group-text search_btn"><i class="ti-search"></i></span>
                        </div>
				    </div>
				</div>
			</div>
            <div class="card-body contacts_body">
				
                <?php 
                foreach($know as $friend){
                    $id_friend = $friend['id'];
                    $name_friend = $friend['firstname']. " " . $friend['lastname'];
                    $email_friend = $friend['email'];
                    $friends = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $id_friend and user_id = $user_id and confirm = 'accept' or user_id = $id_friend and friend_id = $user_id and confirm = 'accept' ");
                    if(empty($friends)){
                        
                        continue;
                    }else {
                ?>
                    <a class="btn_message btn d-flex" style="margin-bottom: 10px;" email_out="<?php echo $email_friend; ?>" incoming-msg-id="<?php echo $user_id; ?>" outgoing-msg-id="<?php echo $id_friend; ?>" 
                    outgoing-name="<?php echo $name_friend; ?>" >
					<div class="d-flex bd-highlight">
						<div class="btn_message img_cont">
							<img src="../img/avartar/<?php echo $friend['img_user'] ; ?>" style="width: 40px; height: 40px" class="rounded-circle user_img">
							<span class="online_icon offline"></span>
						</div>
						<div class="user_info">
							<span><?php echo $name_friend ; ?></span>
							<p><?php echo $friend['status']; ?></p>
						</div>
                        <button type="button" class="btn btn-danger btn-delete-add" user-id-add="<?php echo $user_id; ?>" user-friend-add="<?php echo $id_friend ?>" style="margin-left: 70px">Hủy kết bạn</button>
					</div>
                    </a>
                    
                <?php } } ?>
			</div>
            <hr>
            <center><span>Cuộc trò truyện nhóm <br></span>
            <button class="btn btn-primary" data-toggle="modal" data-target="#create_group">Tạo nhóm </button>
            </center>
            <?php 
            $groups = $db_handle->runQuery("SELECT * FROM group_name");
            foreach($groups as $group){
                $groupid = $group['id'];
                $mems = $db_handle->runQuery("SELECT * FROM group_mem where id_mem = $user_id and group_id = $groupid");
                if(!empty($mems)){
                    $width = "100%";
                    if($user_id == $group['id_host']){
                        $width = "200px";
                    }
                    echo '<a href="#" class="btn_group d-flex flex-row py-2 px-1 text-dark side-nav rounded btn mt-3" style="width: '. $width.'  ;margin-bottom: 10px; float:left;" id_send="'.$user_id .'" 
                    group_id="'. $groupid .'" group-name="'. $group['group_name'] .'">
                    <div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left: -40px;">
                    </div>
                    <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                    <span class="ml-3" style="margin-top: 10px;"><b>'. $group['group_name'] .' </b></span>
                    </a>
                    ';
                }
                
                if($group['id_host'] == $user_id){
                    echo '<button type="button" class="btn btn-default p-2 btn-add-group" style="float:right; margin-top: 15px;" 
                    group_id_mem="'. $group['id'] .'" user_id="'.$user_id .'">Thêm Thành viên</button>
                    
                    
                    <input type="hidden" name="group_id" id="group_id" value="'. $group['id'] . '">
                    ';
                }
            }
            
            ?>
    </div>

    <div class="wrapper-add" style="display:none; margin-left: 60%; ">
    <div class="main">
        <div class="px-2 scroll " id="get_form">
        
        </div>
        </div>  
    </div>
    
    <div class="wrapper-email" style="display: none ; margin-left: 60%; ">
    <div class="main">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="pb-3">Send Email</span> <i class="ti-close btn close-email"></i> </div>
        <div class="px-2 scroll " >
        <form action="" method="post" id="send_email" enctype="multipart/form-data">
            <div class="form-group">
                <span>To: </span>
                <input type="hidden" name="email_user" value="<?php echo $email; ?>">
                <input type="text" class="form-control" name="email_to" id="email_to" value="" readonly>
            </div>
            <div class="form-group">
                <span>subject: </span>
                <input type="text" class="form-control" name="theme" id="theme" >
            </div>
            <div class="form-group">
                <span>Message: </span>
                <textarea class="form-control" name="msg_email" id="msg_email" cols="40" rows="4"></textarea>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" multiple="multiple" name="file_email[]" id="file_email" >
            </div>
            <input type="submit" class="btn btn-success submit_email" value="Send" style="float: right;">
        </form>
        </div>
        </div>  
    </div>

    <div class="wrapper" style="display: none ; ">
    <div class="main">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="chat_name pb-3">Live chat</span>
    <button class="btn btn-send-mail" data=""><i class="ti-email"></i></button> <i class="ti-close btn close-msg"></i> </div>
        <div class="px-2 scroll " id="get_message">
            
        </div>
        <div class="bg-white navbar-expand-sm d-flex justify-content-between">
            <span class="file_upload"></span>
            <img src="" alt="" class="img_msg">
        </div>
        <form action="" method="post" id="msg_form" class="navbar bg-white navbar-expand-sm d-flex justify-content-between" enctype="multipart/form-data">
            <input type="text" name="text-message" class="form-control-message text-message" placeholder="Type a message and enter to send...">
            <input type="hidden" name="incoming_msg" id="incoming_msg" >
            <input type="hidden" name="outgoing_msg" id="outgoing_msg">
            <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2">
            <input type="file" name="upload_file" id="upload_file">
            <label for="upload_file"><i class="ti-files icon1" form="msg_form"></i></label></div>
            <i class="ti-target icon2 send_chat"></i>
        </form>
            
    </div>
    

    </div>
    <div class="wrapper-group"style="display: none;" >
    <div class="main">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="group_name pb-3">Live chat</span> <i class="ti-close btn close-group"></i> </div>
        <div class="px-2 scroll " id="get_chat_msg">
            
        </div>
        <div class="bg-white navbar-expand-sm d-flex justify-content-between">
            <span class="file_upload_group"></span>
            <img src="" alt="" class="img_msg_group">
        </div>
        <form action="" method="post" id="msg_group_form" class="navbar bg-white navbar-expand-sm d-flex justify-content-between" enctype="multipart/form-data">
            <input type="text" name="text-message-group" class="form-control-message text-message-group" placeholder="Type a message and enter to send...">
            <input type="hidden" name="group_id" class="group_id" >
            <input type="hidden" name="id_send" id="id_send" >
            <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2">
            <input type="file" name="upload_file_group" id="upload_file_group">
            <label for="upload_file_group"><i class="ti-files icon1" form="msg_group_form"></i></label></div>
            <i class="ti-target icon2 send_chat_group"></i>
        </form>
    </div>
    </div>


    
    <script src="../js/user/user.js"></script>
    <div class="create-post">
        <?php include "createpost.php"; ?> 
    </div>
    <div class="dete-post">
        <?php include "delete_post.php"; ?> 
    </div>
    <div class="create_group_chat">
        <?php include "create_group_chat.php" ?>                        
    </div>
    <script src="../js/home/home.js"></script>
    