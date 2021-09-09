<div class="modal fade" id="create_group" role="dialog">
    <div class="modal-dialog btn-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title group-title">Create Group Chat</h5>
            </div>
            <div class="modal-body">
                <span>Please input your friend want to join group.</span>
            </div>
            <form action="" method="POST" id="create-group-chat">
                <span>Input your name group <br></span>
                <input type="text" name="name_group" id="name_group" style = "margin-left: 20px">
                <input type="hidden" name="host_id" id="host_id" value="<?php echo $user_id; ?>">
                <div class="friend_list">
                <ul class="contacts" style="list-style-type: none;">
                <hr>
                <?php 
                foreach($know as $friend){
                    $id_friend = $friend['id'];
                    $name_friend = $friend['firstname']. " " . $friend['lastname'];

                    $friends = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $id_friend and user_id = $user_id and confirm = 'accept' or user_id = $id_friend and friend_id = $user_id and confirm = 'accept' ");
                    if(empty($friends)){
                        continue;
                    }else {
                ?>
				<li>
                    <label for="<?php echo $id_friend; ?>" class="btn" incoming-msg-id="<?php echo $user_id; ?>" outgoing-msg-id="<?php echo $id_friend; ?>" outgoing-name="<?php echo $name_friend; ?>">
					<div class="d-flex bd-highlight">
						<div class="img_cont">
							<img src="../img/avartar/<?php echo $friend['img_user'] ; ?>" style="width: 40px; height: 40px" class="rounded-circle user_img">
							<span class="online_icon offline"></span>
						</div>
						<div class="user_info">
							<span><?php echo $name_friend ; ?></span>
							<p><?php echo $friend['status']; ?></p>
						</div>
                        <div class="">
                            <input type="checkbox" class="form-check-input" name="<?php echo $id_friend; ?>" id="<?php echo $id_friend; ?>" style="margin-left: 70px">
                        </div>
					</div>
                    </label>
				</li>
                <?php } } ?>
			    </ul>
                </div>
            <div class="modal-footer">
                <button type="button" id="btn-create-group" class="btn btn-success" >Create</button>
                <button type="button" id="btn-close-create" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
const create_group_chat = document.querySelector("#create-group-chat");
create_group_chat.onsubmit = (e) => {
    e.preventDefault();
}
$("#btn-create-group").click(function (e){
    let xhr = new XMLHttpRequest();// tạo sml object
        xhr.open("POST","ajax.php?action=create_group",true),
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);  
                    if(data == "success"){
                        location.href = "home.php";
                    }else{
                        
                    }
                }
            }
        }
    let formData = new FormData(create_group_chat);
    xhr.send(formData);
});
</script>