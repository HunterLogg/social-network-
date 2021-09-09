const form = document.querySelector("#confirm-form"),
confirmBtn = form.querySelector('#confirm'),
errorMessage = form.querySelector('.form-message');
//console.log(errorMessage);


form.onsubmit = (e) => {
    e.preventDefault();
}

$(document).ready(function (e) {
    $(function() {
        $("#img_file").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                $("#img_file").css("color","red");
                $("#error-message").html('Vui lòng chọn lại file hình ảnh !!.');
                $('#img-review').css("display", "none");
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
        $("#img_file").css("color","green");
        $('#img-review').css("display", "block");
        $('#img-review').attr('src', e.target.result);
        $('#img-review').attr('width', '220px');
        $('#img-review').attr('height', '150px');
    };
});

confirmBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajaxregister.php?action=confirm",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                        if(data == 'success'){
                            location.href = "/facebookapp/home";
                        }else{
                            errorMessage.textContent = data;
                        }
                    }
                }
            }
    let formData = new FormData(form);
    xhr.send(formData);
}