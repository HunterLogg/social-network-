<div class="modal fade" id="detele_post" role="dialog">
    <div class="modal-dialog btn-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Post</h5>
            </div>
            <div class="modal-body">
                <span>Are you sure to delete this post?</span>
            </div>
            <form action="" method="POST" id="delete_form">
                <input type="hidden" name="post_id_delete" id="post_id_delete">
            
            <div class="modal-footer">
                <button type="button" id="btncontinue" class="btn btn-primary" data-dismiss="modal" >Continue</button>
                <button type="button" id="btnclose" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteform = document.querySelector("#delete_form");
    $("#btncontinue").click(function (e){
        let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=delete-post",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        //console.log(data);  
                        location.href = "home.php";
                    }
                }
            }
        let formData = new FormData(deleteform);
        xhr.send(formData);
	});

</script>