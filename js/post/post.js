const postform = document.querySelector("#post_form"),
btnpost = postform.querySelector("#btn_post"),
btnimg = postform.querySelector("#post_img"),
errorMessages = postform.querySelector("#error-message");
postform.onsubmit = (e) => {
    e.preventDefault();
}

$(document).ready(function (e) {
    // edit / delete / add post
	$(".edit_post").click(function (e){
        $("#titles").text("Chỉnh sửa bài viết");
        $("#content").val($(this).attr('data'));
        $("#post_id").val($(this).attr('data-id'));
        $("#type").val($(this).attr("type"));
        $("#taget").val($(this).attr("taget"));
        $("#action").val("edit");
        $("#img_review").attr('src', "../img/posts/" + $(this).attr("data-img"))

        $("#btn_post").text("UPDATE");
	});
    $("#btn_write_post").click(function (e){
        $("#titles").text("Tạo bài viết");
        $("#content").val('');
        $("#type").val('1');
        $("#action").val("add");
        $("#img_review").attr('src', "");
        $("#btn_post").text("POST");
	});

    $(".delete_post").click(function (e){
        $("#post_id_delete").val($(this).attr('data-id'));
	});
    $(function() {
        $("#post_img").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                $("#post_img").css("color","red");
                $("#error-message").html('Vui lòng chọn lại file hình ảnh !!.');
                $('#img_review').css("display", "none");
                return false;
            }
            else
            {
                $("#error-message").html('');
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoaded(e) {
        $("#post_img").css("color","green");
        $('#img_review').css("display", "block");
        $('#img_review').attr('src', e.target.result);
        $('#img_review').attr('width', '250px');
        $('#img_review').attr('height', '240px');
    };
});


$('.comment-textfield').on('keypress',function(e){
    if(e.which == 13 && e.shiftKey == false){
        var post_id = $(this).attr('data-id')
        var user_id = $(this).attr('user-id')
		var comment = $(this).val()
		$(this).val('')
		$.ajax({
			url:'ajax.php?action=comment',
			method:'POST',
			data:{post_id:post_id,comment:comment,user_id:user_id},
			success:function(resp){
				if(resp){
					//console.log(resp);
                    $(".card-comment").append(resp);
                    //console.log(result[3]);
                    
				}
			}
		})
		return false;
    }
});


$('.comment-textfield').on('change keyup keydown paste cut', function (e) {
	if(this.scrollHeight <= 117)
        $(this).height(0).height(this.scrollHeight);
})

btnpost.onclick = ()=>{
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=post",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){

                        let data = xhr.response;
                        console.log(data);  
                         if(data == 'home'){
                              location.href = "home.php";
                        }
                        else{
                            location.href = data;
                        }
                    }
                }
            }
    let formData = new FormData(postform);
    xhr.send(formData);
}

