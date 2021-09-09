
    <style>
	.text-dark{
		color:black!important;
	}
	.cover-pic{
		width: 100%;
	    height: 100%;
	    object-fit: cover;
	}
	#profile-field{
		background: rgb(246,246,246);
		background: linear-gradient(0deg, rgba(246,246,246,1) 0%, rgba(132,185,238,1) 62%, rgba(0,151,255,1) 100%);
	}
	.gallery__img {
	    width: 100%;
	    height: 100%;
	    object-fit: cover;
	}
	.gallery {
	    display: grid;
	    grid-template-columns: repeat(2, 50%);
	    grid-template-rows: repeat(2, 30vh);
	    grid-gap: 3px;
	    grid-row-gap: 3px;
	}
	.gallery__item{
		margin: 0
	}
</style>
</head>
<?php 
include("homeheader.php");
require_once("../DBController.php");
$db_handle = new DBController();
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id ='$id'";
$sql = $db_handle->runQuery($query);
$name = $sql[0]['firstname']. " " . $sql[0]['lastname'];
$imgPath = $sql[0]['img_user'];
$imgCover = $sql[0]['img_cover'];
$dob = $sql[0]['dob'];
$contact = $sql[0]['contact'];
$gender = $sql[0]['gender'];
$hiden = "";
if($user_id != $id){
  $hiden = "none";
}
?>
<body>
    <div class="row shadow-sm" id="profile-field">
        <div class="container">
            <div class="col-lg-10 offset-md-1" style="height:60vh">
                <div class="position-relative image-fluid w-100 mb-1" style="height:65%">
                    <img src="../img/avartar/<?php echo $imgCover;?>" alt="" class="gallery__image cover-pic  rounded-bottom">
                    <div class="position-absolute" style="top:85%;right:3%;z-index:1">
                    <form action="" method="post" id="form_edit_cover" style="display:<?php echo $hiden ?>;">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                        <input type="hidden" name="type" value="cover">
                        <input type="file" name="edit_cover" id="edit_cover" style="display:none;">
                        <label for="edit_cover" class="btn btn-dark btn-sm bg-dark" type="button" id="edit_cover_btn"><i class="ti-camera"></i> Edit Cover Photo</label>
                    </form>
                    </div>
                    <div class="w-100 d-flex justify-content-center position-absolute" style="top:50%">
                        <span class="position-relative">
                            <img src="../img/avartar/<?php echo $imgPath;?>" alt="" class=" img-thumbnail rounded-circle" style="width:150px;height: 150px">
                            <form action="" method="post" id="form_edit_pp" style="display:<?php echo $hiden ?>;">
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                            <input type="hidden" name="type" value="avartar">
                            <input type="file" name="edit_cover" id="edit_pp" style="display:none;">
                            <label for="edit_pp" href="" id="edit_pp_btn" class="btn text-dark position-absolute rounded-circle img-thumbnail d-flex justify-content-center align-items-center" style="top:75%;left:75%;width:25px;height: 25px"><i class="ti-camera rounded-circle"></i></label>
                            </form>
                          </span>
                    </div>
                </div>
                <div class="d-block w-100 py-2 px-1 text-center">
                    <h2 class="text-dark text-center"><b><?php echo $name;?></b></h2>
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-2 px-1">
        <div class="col-lg-10 offset-md-1">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                      </div>
                          <!-- /.card-header -->
                          <div class="card-body">
    
                            <strong><i class="fas fa-calendar-day mr-1"></i> Date of Birth</strong>
    
                            <p class="text-muted"><?php echo $dob; ?></p>
    
                            <hr>
    
                            <strong><i class="fa fa-phone mr-1"></i> Contact</strong>
    
                            <p class="text-muted"><?php echo $contact; ?></p>
                            <hr>
                            <strong><i class="far fa-user mr-1"></i> Gender</strong>
    
                            <p class="text-muted"><?php echo $gender; ?></p>
                          </div>
                          <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-8">
                <?php 
                $posts = $db_handle->runQuery("SELECT * FROM posts WHERE user_id = $id ORDER BY id DESC");
                if(!empty($posts)){
                  foreach($posts as $post){
                    $date_post = $post['date'];
                    $post_id = $post['id'];
                    $content_post = $post['content'];
                    $imgPath_post = $post['img_path'];
                    $post_user_id = $post['user_id'];
                    $type = $post['type'];
                    $taget = "user_profile.php?id=". $user_id;
                    if($post['type'] == 0 && $user_id != $post_user_id){
                      continue;
                    }
                ?>
                <div class="col-md-12">
                
                <div class="card card-widget post-card" data-id="">
                  <div class="card-header">
                    <div class="user-block">
                      <img class="img-circle" src="../img/avartar/<?php echo $imgPath;?>" alt="User Image">
                      <span class="username"><a href="#"><?php echo $name; ?></a></span>
                      <span class="description">Posted - <?php echo $post['date'] ?></span>
                    </div>
                    <!-- /.user-block -->
                    <?php if($post_user_id == $user_id) 
                            echo '<div class="card-tools " style="float: right;">
                            <div class="dropdown">
                              <button type="button" class="btn btn-tool" data-toggle="dropdown" title="Manage">
                              <i class="ti-more-alt"></i>
                              </button>
                            <div class="dropdown-menu" style="transform: translate3d(-109px, 44px, 0px); top: 0px; left: 0px; will-change: transform;">
                              <button class="edit dropdown-item edit_post btn" data-toggle="modal" data-target="#write_post" data-img="'. $imgPath_post .'" type="'. $type .'" 
                              taget="'. $taget .'" data="'. $content_post .'" data-id="'. $post_id .'">Edit</button>
                              <button class="dropdown-item delete_post btn" data-toggle="modal" data-target="#detele_post" data-id="'. $post_id .'" href="">Delete</button>
                            </div>
                            </div>
                            </div>';?>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
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
                            ?>
                            <img src="../img/posts/<?php echo $imgPath_post?>" alt="" class="w-100" >
                            <button type="button" class="btn btn-default btn-sm" data-id="" style="margin-top: 20px"><i class="ti-thumb-up"></i> Like</button>
                    </div>
                  <!-- /.card-body -->
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
                  </div>
                  <!-- /.card-footer -->
                   <div class="card-footer">
                      <form action="#" method="post">
                        <i class="img-fluid img-circle img-sm ti-comments" style="float:left ; margin-top: 10px"></i>
                        <div class="img-push">
                          <textarea cols="30" rows="1" class="form-control comment-textfield" style="resize:none; float:right;" placeholder="Press enter to post comment" name="comment-text" user-id="<?php echo $user_id; ?>" data-id="<?php echo $post_id; ?>"></textarea>
                        </div>
                      </form>
                    </div>
                  <!-- /.card-footer -->
                </div>
                </div>
                
                <?php 
                  }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none " id="comment-clone">
    <div class="card-comment">
        <!-- User image -->
        <img class="img-circle img-sm" src="" alt="User Image">
    
        <div class="comment-text">
        <span class="username">
            <span class="uname">Maria Gonzales</span>
            <span class="text-muted float-right timestamp">8:03 PM Today</span>
        </span><!-- /.username -->
        <span class="comment">
        It is a long established fact that a reader will be distracted
        by the readable content of a page when looking at its layout.
        </span>
        </div>
        <!-- /.comment-text -->
    </div>
    </div>
    <script src="../js/post.js"></script>
    <div class="create-post">
        <?php include "createpost.php"; ?> 
    </div>
    <div class="dete-post">
        <?php include "delete_post.php"; ?> 
    </div>

<script>
  const form_edit_cover = document.querySelector("#form_edit_cover");
  form_edit_cover.onsubmit = (e) => {
      e.preventDefault();
  }
  const form_edit_pp = document.querySelector("#form_edit_pp");
  form_edit_pp.onsubmit = (e) => {
      e.preventDefault();
  }
  $(document).ready(function(){
    $(function() {
    $("#edit_cover").change(function() {
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      {

      }
      else
      {
        let xhr = new XMLHttpRequest();// tạo sml object
              xhr.open("POST","ajax.php?action=edit-img",true),
              xhr.onload = () => {
                  if(xhr.readyState === XMLHttpRequest.DONE){
                      if(xhr.status === 200){
                          let data = xhr.response;
                          //console.log(data);  
                          if(data="success"){
                            location.reload()
                          }
                      }
                  }
              }
        let form_edit_cover_data = new FormData(form_edit_cover);
        xhr.send(form_edit_cover_data);
      }
    });
    $("#edit_pp").change(function() {
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      {

      }
      else
      {
        let xhr = new XMLHttpRequest();// tạo sml object
              xhr.open("POST","ajax.php?action=edit-img",true),
              xhr.onload = () => {
                  if(xhr.readyState === XMLHttpRequest.DONE){
                      if(xhr.status === 200){
                          let data = xhr.response;
                          location.reload()
                          console.log(data); 
                          if(data="success"){
                            location.reload()
                          } 
                      }
                  }
              }
        let form_edit_pp_data = new FormData(form_edit_pp);
        xhr.send(form_edit_pp_data);
      }
    });
  });
});
//22 file
</script>
</body>
</html>