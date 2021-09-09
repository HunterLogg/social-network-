
window.start_load = function(){
  $('body').prepend('<div id="preloader2"></div>')
  }
  window.end_load = function(){
  $('#preloader2').fadeOut('fast', function() {
      $(this).remove();
    })
   }
  window.uni_modal = function($title = '' , $url='',$size=""){
  start_load();
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal .modal-dialog').addClass($size)
                }else{
                    $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
                }
                $('#uni_modal').modal({
                  show:true,
                  backdrop:'static',
                  keyboard:false,
                  focus:true
                })
                end_load()
            }
        }
    })
    }
    $('#new_account').click(function(){
    uni_modal("<h4>Đăng Ký</h4><span><h6 class='text-muted'>Nhanh chóng và dễ dàng.</h6></span>","register/register.php")
  })

const form = document.querySelector("#login-form"),
continueBtn = form.querySelector('#login'),
errorText = form.querySelector('.form-message');
form.onsubmit = (e) => {
    e.preventDefault();
}
continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","login/ajaxlogin.php",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        if(data == "success"){
                            location.href = "home/home.php";
                        }else {
                            var email = form.querySelector("#email");
                            email.classList.add('is-invalid');
                            var password = form.querySelector("#password");
                            password.classList.add('is-invalid');
                            errorText.textContent = data;
                        }
                        
                        console.log(data);  
                    }
                }
            }
    let formData = new FormData(form);
    xhr.send(formData);
}

