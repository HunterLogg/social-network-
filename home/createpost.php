<?php
    require_once("../DBController.php");
    $db_handle = new DBController(); 
    if(isset( $_SESSION['email'])){
    $email = $_SESSION['email'];
    $query = "SELECT * FROM users WHERE email ='$email'";
    $sql = $db_handle->runQuery($query);
    $id= $sql[0]['id'];
    $name = $sql[0]['firstname']. " " . $sql[0]['lastname'];
    $imgPath = $sql[0]['img_user'];
    }
?>
<div class="modal fade position-fixed" id="write_post" role="dialog">
        <div class="modal-dialog btn-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal"></button> -->
                    <h4 class="modal-title"><label id="titles">Tạo bài viết</label></h4>
                </div>
                <div class="modal-body">
                <form action="" id="post_form">
                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $id; ?>">
                    <div class="d-flex w-100 align-items-center">
                        <div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left: -40px">
                              <img src="../img/avartar/<?php echo $imgPath ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                        </div>
                        <div class="ml-4 text-left" style="width:calc(80%)">
                            <div><small</small></div>
                            <input type="hidden" name="post_id" id="post_id" value="" >
                            <input type="hidden" name="action" id="action" value="add">
                            <input type="hidden" name="taget" id="taget" value="">
                            <select class="form-select badge badge-light text-white dropdown-toggle" name="type" id="type" aria-label="Default select example" style="width:calc(30%)">
                                <option value="0">Chỉ mình tôi</option>
                                <option value="1" selected>Công khai</option>
                            </select>
                        </div>
                    </div>
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="5" class="form-control" placeholder="<?php echo  $sql[0]['lastname'] ?> ơi, bạn đang nghĩ gì thế?" style="resize:none;border: none"></textarea>
                </div>
                <div class="img_view">
                    <center><img src="" alt="" id="img_review" style="width: 40%;"></center>
                </div>
                <div class="card solid">
                    <div class="card-body">
                    <input type="file" name="post_img" id="post_img" style="display:none;">
                    <label for="post_img" style="cursor: pointer;">
                        <div class="btn d-flex justify-content-between align-items-center" taget="post_img">
                            <small>Add to Your Post</small>
                            <span style="margin-left: 290px">
                                <i class="ti-image text-success rounded-circle" ></i>
                            </span>
                        </div>
                        </label>
                    </div>
                </div>
                <center><span class="text-danger" id="error-message"></span></center>
                <div class="modal-footer display py-1 px-1">
                    <div class="d-block w-100">
                        <button class="btn btn-block btn-primary btn-sm" id="btn_post" >POST</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/post/post.js"></script>