const managerform = document.querySelector("#manage_account"),
btnsave = managerform.querySelector("#btnSave"),
errorMessage= managerform.querySelector(".form-message");
//console.log(managerform);


btnsave.onclick = ()=>{
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax.php?action=edit-account",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                        if(data == 'success'){
                             location.href = "home.php";
                        }else{
                            errorMessage.textContent = data;
                        }
                    }
                }
            }
    let formData = new FormData(managerform);
    xhr.send(formData);
}