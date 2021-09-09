var incoming_msg_id ;
var outgoing_msg_id;
var id_send;
var group_id;
$(document).ready(function(){
    $(function() {
        $("#upload_file").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                var filename = file.name;
                const myArr = filename.split(".");
                var allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(jQuery.inArray(myArr[1], allowed) != -1){
                    $(".img_msg").hide();
                    $(".file_upload").show();
                    $('.file_upload').css("margin-left", "20px");
                    $(".file_upload").text(filename);
                }
            }
            else
            {
                $(".img_msg").show();
                $(".file_upload").hide();
                $('.img_msg').css("margin-left", "20px");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
        $("#upload_file_group").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                var filename = file.name;
                const myArr = filename.split(".");
                var allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(jQuery.inArray(myArr[1], allowed) != -1){ 
                    $(".img_msg_group").hide();
                    $(".file_upload_group").show();
                    $('.file_upload_group').css("margin-left", "20px");
                    $(".file_upload_group").text(filename);
                }
            }
            else
            {
                $(".img_msg_group").show();
                $(".file_upload_group").hide();
                var reader = new FileReader();
                reader.onload = imageIsLoadedGroup;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoadedGroup(e) {
        $('.img_msg_group').css("display", "block");
        $('.img_msg_group').attr('src', e.target.result);
        $('.img_msg_group').attr('width', '50px');
        $('.img_msg_group').attr('height', '50px');
    };
    function imageIsLoaded(e) {
        $('.img_msg').css("display", "block");
        $('.img_msg').attr('src', e.target.result);
        $('.img_msg').attr('width', '50px');
        $('.img_msg').attr('height', '50px');
    };

    

    $(".btn_message").click(function (e){
        $(".wrapper").show();
        $("#get_message").html('');
        incoming_msg_id =  $(this).attr('incoming-msg-id');
        outgoing_msg_id = $(this).attr('outgoing-msg-id');
        $("#incoming_msg").val(incoming_msg_id);
        $("#outgoing_msg").val(outgoing_msg_id);
        $(".btn-send-mail").attr('data', $(this).attr('email_out'));
        $(".chat_name").text($(this).attr('outgoing-name'));
        $('.wrapper-group').css("margin-left", "10px");
        if($(".wrapper-group").css('display') === 'none'){
            $('.wrapper').css("margin-left", "75%");
        }
	});

    $(".btn-send-mail").click(function (e){
        $(".wrapper").hide();
        $(".wrapper-email").show();
        $("#email_to").val($(this).attr('data'));
	});

    $(".btn_group").click(function (e){
        $(".wrapper-group").show();
        $("#get_chat_msg").html('');
        $('.wrapper').css("margin-left", "55%");
        if($(".wrapper").css('display') === 'none'){
            $('.wrapper-group').css("margin-left", "75%");
        }
        group_id =  $(this).attr('group_id');
        console.log(group_id)
        id_send = $(this).attr('id_send');
        $(".group_name").text($(this).attr('group-name'));
        $(".group_id").val(group_id);
        $("#id_send").val($(this).attr('id_send'));
        document.getElementById('get_chat_msg').scrollTop = document.getElementById('get_chat_msg').scrollHeight;

	});
    
    $(".close-email").click(function (e){
        $(".wrapper-email").hide();

	});
    $(".close-msg").click(function (e){
        $(".wrapper").hide();

	});
    $(".close-group").click(function (e){
        $(".wrapper-group").hide();

	});
 
    $(".btn-add-group").click(function (e){
        $(".wrapper-add").show();
        $("#get_form").empty();
        var user_id = $(this).attr('user_id');
        var group_id_mem = $(this).attr('group_id_mem');
        $.ajax({
		url:'ajax.php?action=btn-add-group',
		method:'POST',
		data:{user_id:user_id,group_id_mem:group_id_mem},
		success:function(resp){
			if(resp){
                
				//console.log(document.getElementById('get_message'));
                $("#get_form").html(resp);
			}
		}
	    })
        
	});
    
});
// like post
$(".btn-sm").click(function (e){
    var user_id = $(this).attr('data-id');
    var post_id = $(this).attr('post_id');
    $.ajax({
		url:'ajax.php?action=like-post',
		method:'POST',
		data:{user_id:user_id,post_id:post_id},
		success:function(resp){
			if(resp){
                //console.log(resp);
			}
	    }
    })
});

//send email 
const emailform = document.querySelector("#send_email");
emailform.onsubmit = (e) => {
    e.preventDefault();
}
$(".submit_email").click(function (e){
    $(".wrapper-email").hide();
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=send-email",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                        if(data=="success"){
                            alert("Email đã được gửi.");
                        }
                    }
                }
            }
        let emailformdata = new FormData(emailform);
        xhr.send(emailformdata);
});

//send chat group
const group_form = document.querySelector("#msg_group_form");
group_form.onsubmit = (e) => {
    e.preventDefault();
}
// khi enter message group ;
$('.text-message-group').on('keypress',function(e){
    if(e.which == 13 && e.shiftKey == false){
        
        let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=insert_chat_group",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                    }
                }
            }
        let formData = new FormData(group_form);
        xhr.send(formData);
        $("#upload_file_group").val('');
        $('.img_msg_group').attr('src', "");
        $('.img_msg_group').hide();
        $(".file_upload_group").hide();
        $(".file_upload_group").text('');
		$(this).val('');
		return false;
    }
});
// nếu click vào nút để send chat
$(".send_chat_group").click(function (e){
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=insert_chat_group",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        //console.log(data);  
                    }
                }
            }
    let formData = new FormData(group_form);
    xhr.send(formData);
    $("#upload_file_group").val('');
    $('.img_msg_group').attr('src', "");
    $('.img_msg_group').hide();
	$('.text-message-group').val('');
    $(".file_upload_group").text('');
    $(".file_upload_group").hide();
    
});
// lấy chat qua jquery
setInterval(()=>{
    $.ajax({
		url:'ajax.php?action=get_chat_group',
		method:'POST',
		data:{id_send:id_send,group_id:group_id},
		success:function(resp){
			if(resp){
				//console.log(document.getElementById('get_chat_msg'));
                //console.log(resp);
                $("#get_chat_msg").html(resp);
                document.getElementById('get_chat_msg').scrollTop = document.getElementById('get_chat_msg').scrollHeight;
			}
		}
	})

},1000);//function sẽ chạy sau 500ms

// send chat friend
const msg_form = document.querySelector("#msg_form");
msg_form.onsubmit = (e) => {
    e.preventDefault();
}
// nếu click vào nút để send chat
$(".send_chat").click(function (e){
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=insert_chat",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        //console.log(data);  
                        
                    }
                }
            }
    let formData = new FormData(msg_form);
    xhr.send(formData);
    $("#upload_file").val('');
    $('.img_msg').attr('src', "");
    $('.img_msg').hide();
	$('.text-message').val('');
    $(".file_upload").text('');
    $(".file_upload").hide();

});
// khi enter message ;
$('.text-message').on('keypress',function(e){
    if(e.which == 13 && e.shiftKey == false){
        let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=insert_chat",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        //console.log(data);  
                    }
                }
            }
        let formData = new FormData(msg_form);
        xhr.send(formData);
        $("#upload_file").val('');
        $('.img_msg').attr('src', "");
        $('.img_msg').hide();
		$(this).val('');
        $(".file_upload").text('');
        $(".file_upload").hide();
		return false;
    }
});

setInterval(()=>{
    $.ajax({
		url:'ajax.php?action=get_chat',
		method:'POST',
		data:{incoming_msg_id:incoming_msg_id,outgoing_msg_id:outgoing_msg_id},
		success:function(resp){
			if(resp){
				//console.log(document.getElementById('get_message'));
                $("#get_message").html(resp);
                document.getElementById('get_message').scrollTop = document.getElementById('get_message').scrollHeight;
			}
		}
	})

},1000);//function sẽ chạy sau 500ms
